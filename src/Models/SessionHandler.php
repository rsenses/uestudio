<?php

namespace Expomark\Models;

use PDO;

class SessionHandler implements \SessionHandlerInterface
{
    private $savePath;

    /**
     * a database MySQLi connection resource.
     *
     * @var resource
     */
    protected $dbConnection;

    /**
     * the name of the DB table which handles the sessions.
     *
     * @var string
     */
    protected $dbTable;

    /**
     * Set db data if no connection is being injected.
     *
     * @param string $dbHost
     * @param string $dbUser
     * @param string $dbPassword
     * @param string $dbDatabase
     */
    public function setDbDetails($dbHost, $dbPort, $dbUser, $dbPassword, $dbDatabase)
    {
        try {
            $opt = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            $this->dbConnection = new PDO("mysql:host=$dbHost;dbname=$dbDatabase;port=$dbPort;charset=utf8mb4", $dbUser, $dbPassword, $opt);
        } catch (PDOException $e) {
            throw new Exception('Connect Error: '.$e->getMessage());
        }
    }

    /**
     * Inject DB connection from outside.
     *
     * @param object $dbConnection expects MySQLi object
     */
    public function setDbTable($dbTable)
    {
        $this->dbTable = $dbTable;
    }

    public function open($savePath, $sessionName)
    {
        $sql = "DELETE FROM $this->dbTable WHERE timestamp < ?";
        $params = [
            time() - (3600 * 24),
        ];

        return $this->dbConnection->prepare($sql)->execute($params);
    }

    public function close()
    {
        $this->dbConnection = null; // only close lazy-connection

        return true;
    }

    public function read($id)
    {
        $sql = "SELECT data FROM $this->dbTable WHERE session_id = ?";
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->execute([$id]);
        if ($result = $stmt->fetch()) {
            return $result['data'];
        } else {
            return '';
        }
    }

    public function write($id, $data)
    {
        $sql = "REPLACE INTO $this->dbTable (session_id, data, timestamp) VALUES(?, ?, ?)";
        $params = [
            $id,
            $data,
            time(),
        ];

        return $this->dbConnection->prepare($sql)->execute($params);
    }

    public function destroy($id)
    {
        $sql = "DELETE FROM $this->dbTable WHERE session_id = ?";
        $params = [
            $id,
        ];

        return $this->dbConnection->prepare($sql)->execute($params);
    }

    public function gc($maxlifetime)
    {
        $sql = "DELETE FROM $this->dbTable WHERE timestamp < ?";
        $params = [
            time() - intval($maxlifetime),
        ];

        return $this->dbConnection->prepare($sql)->execute($params);
    }
}
