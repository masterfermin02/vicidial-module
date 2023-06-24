<?php

namespace App\Services;

use Illuminate\Database\Capsule\Manager;
use DI\Container;

class AsteriskDBServices
{
    protected string $PATHlogs;
    protected string $WeBServeRRooT;
    protected string $WEBserver_ip;
    protected string $VARDB_server;
    protected string $VARDB_database;
    protected string $VARDB_user;
    protected string $VARDB_pass = '';
    protected string $VARDB_port;
    protected string $VARDB_custom_user;
    protected string $VARDB_custom_pass;


    public function register(Container $container)
    {
        $this->loadFilesVariables();
        $capsule = new Manager();

        $capsule->addConnection([
            'driver'    => 'mysql',
            'host'      => $this->VARDB_server,
            'database'  => $this->VARDB_database,
            'username'  => $this->VARDB_user,
            'password'  => $this->VARDB_pass,
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]);

        // Make this Capsule instance available globally via static methods... (optional)
        $capsule->setAsGlobal();

        // Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
        $capsule->bootEloquent();

        $container->set('db', fn () => $capsule);
    }

    protected function loadFilesVariables()
    {
        if ( file_exists("/etc/astguiclient.conf") )
        {
            $DBCagc = file("/etc/astguiclient.conf");
            foreach ($DBCagc as $DBCline)
            {
                $DBCline = preg_replace("/ |>|\n|\r|\t|\#.*|;.*/","",$DBCline);
                if (preg_match("/^PATHlogs/", $DBCline))
                {$this->PATHlogs = $DBCline;   $this->PATHlogs = preg_replace("/.*=/","",$this->PATHlogs);}
                if (preg_match("/^PATHweb/", $DBCline))
                {$this->WeBServeRRooT = $DBCline;   $this->WeBServeRRooT = preg_replace("/.*=/","",$this->WeBServeRRooT);}
                if (preg_match("/^VARserver_ip/", $DBCline))
                {$this->WEBserver_ip = $DBCline;   $this->WEBserver_ip = preg_replace("/.*=/","",$this->WEBserver_ip);}
                if (preg_match("/^VARDB_server/", $DBCline))
                {$this->VARDB_server = $DBCline;   $this->VARDB_server = preg_replace("/.*=/","",$this->VARDB_server);}
                if (preg_match("/^VARDB_database/", $DBCline))
                {$this->VARDB_database = $DBCline;   $this->VARDB_database = preg_replace("/.*=/","",$this->VARDB_database);}
                if (preg_match("/^VARDB_user/", $DBCline))
                {$this->VARDB_user = $DBCline;   $this->VARDB_user = preg_replace("/.*=/","",$this->VARDB_user);}
                if (preg_match("/^VARDB_pass/", $DBCline))
                {$this->VARDB_pass = $DBCline;   $this->VARDB_pass = preg_replace("/.*=/","",$this->VARDB_pass);}
                if (preg_match('/^VARDB_custom_user/', $DBCline))
                {$this->VARDB_custom_user = $DBCline;   $this->VARDB_custom_user = preg_replace("/.*=/","",$this->VARDB_custom_user);}
                if (preg_match('/^VARDB_custom_pass/', $DBCline))
                {$this->VARDB_custom_pass = $DBCline;   $this->VARDB_custom_pass = preg_replace("/.*=/","",$this->VARDB_custom_pass);}
                if (preg_match("/^VARDB_port/", $DBCline))
                {$this->VARDB_port = $DBCline;   $this->VARDB_port = preg_replace("/.*=/","",$this->VARDB_port);}
                if (preg_match("/^ExpectedDBSchema/", $DBCline))
                {$this->ExpectedDBSchema = $DBCline;   $this->ExpectedDBSchema = preg_replace("/.*=/","",$this->ExpectedDBSchema);}
            }
        } else {
            $this->VARDB_server = "127.0.0.1:13307";
            $this->VARDB_database = "asterisk";
            $this->VARDB_user = "root";
        }
    }

    public function getWeBServeRRooT(): string
    {
        return $this->WeBServeRRooT;
    }

    public function getWEBserver_ip(): string
    {
        return $this->WEBserver_ip;
    }

    public function getHost(): string
    {
        list($host) = explode(':', $this->VARDB_server);
        return $host;
    }

    public function getPort(): string
    {
        list($host, $port) = explode(':', $this->VARDB_server);
        return $port;
    }

    public function getDatabase(): string
    {
        return $this->VARDB_database;
    }

    public function getUser(): string
    {
        return $this->VARDB_user;
    }

    public function getPass(): string
    {
        return $this->VARDB_pass;
    }
}
