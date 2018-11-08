<?php

use yii\db\Schema;
use yii\db\Migration;

use app\models\User;
use app\models\UserEmail;
use app\models\UserPassword;

class m151109_100547_setup extends Migration
{
    public function up()
    {
        // settings table
        $this->createTable('setting', [
            'id' => 'int(11) unsigned not null auto_increment PRIMARY KEY',
            'key' => $this->string()->notNull(),
            'value' => $this->text(),
        ], 'ENGINE=INNODB');
        
        $this->createIndex('setting_key_unique_key', 'setting', 'key', true);
        
        // operation system table
        $this->createTable('os', [
            'id' => 'int(11) unsigned not null auto_increment PRIMARY KEY',
            'name' => $this->string()->notNull(),
			'type' => $this->string()->notNull(),
			'username' => $this->string(),
			'password' => $this->string(),
            'created_at' => 'int(11) unsigned not null',
            'updated_at' => 'int(11) unsigned not null',
        ], 'ENGINE=INNODB');
                
        // users table
        $this->createTable('user', [
            'id' => 'int(11) unsigned not null auto_increment PRIMARY KEY',
            'first_name' => $this->string()->notNull(),
            'last_name' => $this->string()->notNull(),
            'auth_key' => $this->string()->notNull(),
            'is_admin' => 'tinyint(1) unsigned not null default 1',
            'created_at' => 'int(11) unsigned not null',
            'updated_at' => 'int(11) unsigned not null',
            'status' => 'tinyint(1) unsigned not null default 1',
        ], 'ENGINE=INNODB');
        
        $this->createIndex('user_auth_key_unique_key', 'user', 'auth_key', true);
                
        // user emails
        $this->createTable('user_email', [
            'id' => 'int(11) unsigned not null auto_increment PRIMARY KEY',
            'user_id' => 'int(11) unsigned not null',
            'email' => $this->string()->notNull(),
            'key' => 'char(16) not null',
            'is_primary' => 'tinyint(1) unsigned not null default 1',
            'is_confirmed' => 'tinyint(1) unsigned not null default 1',
            'created_at' => 'int(11) unsigned not null',
            'updated_at' => 'int(11) unsigned not null',
        ], 'ENGINE=INNODB');

        $this->createIndex('user_email_email_unique_key', 'user_email', 'email', true);
        $this->createIndex('user_email_key_unique_key', 'user_email', 'key', true);
        $this->addForeignKey('user_email_user_id_foreign_key', 'user_email', 'user_id', 'user', 'id', 'CASCADE', 'NO ACTION');
        
        // user passwords
        $this->createTable('user_password', [
            'id' => 'int(11) unsigned not null auto_increment PRIMARY KEY',
            'user_id' => 'int(11) unsigned not null',
            'hash' => 'tinyint(1) unsigned not null default 1',
            'salt' => $this->string()->notNull(),
            'password' => $this->string()->notNull(),
            'created_at' => 'int(11) unsigned not null',
        ], 'ENGINE=INNODB');
        
        $this->addForeignKey('user_password_user_id_foreign_key', 'user_password', 'user_id', 'user', 'id', 'CASCADE', 'NO ACTION');
        
        // user logins histories
        $this->createTable('user_login', [
            'id' => 'int(11) unsigned not null auto_increment PRIMARY KEY',
            'user_id' => 'int(11) unsigned not null',
            'ip' => $this->string(45)->notNull(),
            'os_name' => $this->string()->notNull(),
            'browser_name' => $this->string()->notNull(),
            'created_at' => 'int(11) unsigned not null',
            'status' => 'tinyint(1) unsigned not null default 1',
        ], 'ENGINE=INNODB');
        
        $this->addForeignKey('user_login_user_id_foreign_key', 'user_login', 'user_id', 'user', 'id', 'CASCADE', 'NO ACTION');
        
        // lost password
        $this->createTable('lost_password', [
            'id' => 'int(11) unsigned not null auto_increment PRIMARY KEY',
            'user_id' => 'int(11) unsigned not null',
            'key' => 'char(16) not null',
            'created_at' => 'int(11) unsigned not null',
            'updated_at' => 'int(11) unsigned not null',
            'expired_at' => 'int(11) unsigned not null',
            'status' => 'tinyint(1) unsigned not null default 1',
        ], 'ENGINE=INNODB');
        
        $this->createIndex('lost_password_key_unique_key', 'lost_password', 'key', true);
        $this->addForeignKey('lost_password_user_id_foreign_key', 'lost_password', 'user_id', 'user', 'id', 'CASCADE', 'NO ACTION');
        
        // servers
        $this->createTable('server', [
            'id' => 'int(11) unsigned not null auto_increment PRIMARY KEY',
            'name' => $this->string()->notNull(),
            'ip' => $this->string(45)->notNull(),
            'port' => 'smallint(11) unsigned not null',
            'username' => $this->string()->notNull(),
            'password' => $this->string()->notNull(),
			'license' => $this->string()->notNull(),
            'created_at' => 'int(11) unsigned not null',
            'updated_at' => 'int(11) unsigned not null',
        ], 'ENGINE=INNODB');
                
        // datastores
        $this->createTable('datastore', [
            'id' => 'int(11) unsigned not null auto_increment PRIMARY KEY',
            'server_id' => 'int(11) unsigned not null',
            'value' => $this->string()->notNull(),
            'space' => 'int(11) unsigned not null',
            'is_default' => 'tinyint(1) unsigned not null default 1',
            'created_at' => 'int(11) unsigned not null',
            'updated_at' => 'int(11) unsigned not null',
        ], 'ENGINE=INNODB');
        
        $this->addForeignKey('datastore_server_id_foreign_key', 'datastore', 'server_id', 'server', 'id', 'CASCADE', 'NO ACTION');
        
        // plans
        $this->createTable('plan', [
            'id' => 'int(11) unsigned not null auto_increment PRIMARY KEY',
            'name' => $this->string()->notNull(),
            'ram' => 'int(11) unsigned not null',
            'cpu_mhz' => 'int(11) unsigned not null',
            'cpu_core' => 'int(11) unsigned not null',
            'hard' => 'int(11) unsigned not null',
            'is_public' => 'tinyint(1) unsigned not null default 1',
            'created_at' => 'int(11) unsigned not null',
            'updated_at' => 'int(11) unsigned not null',
        ], 'ENGINE=INNODB');
                
        // ips
        $this->createTable('ip', [
            'id' => 'int(11) unsigned not null auto_increment PRIMARY KEY',
            'server_id' => 'int(11) unsigned not null',
            'ip' => $this->string(45)->notNull(),
            'gateway' => $this->string()->notNull(),
            'netmask' => $this->string()->notNull(),
            'is_public' => 'tinyint(1) unsigned not null default 1',
            'created_at' => 'int(11) unsigned not null',
            'updated_at' => 'int(11) unsigned not null',
        ], 'ENGINE=INNODB');

        $this->createIndex('ip_id_primary_key', 'ip', 'id');
        $this->createIndex('ip_id_unique_key', 'ip', ['server_id', 'ip'], true);
        $this->addForeignKey('ip_server_id_foreign_key', 'ip', 'server_id', 'server', 'id', 'CASCADE', 'NO ACTION');
        
        // vps
        $this->createTable('vps', [
            'id' => 'int(11) unsigned not null auto_increment PRIMARY KEY',
            'user_id' => 'int(11) unsigned not null',
            'server_id' => 'int(11) unsigned not null',
            'datastore_id' => 'int(11) unsigned not null',
            'os_id' => 'int(11) unsigned not null',
            'plan_id' => 'int(11) unsigned not null',
            'password' => $this->string()->notNull(),
            'created_at' => 'int(11) unsigned not null',
            'updated_at' => 'int(11) unsigned not null',
            'status' => 'tinyint(1) unsigned not null default 1',
        ], 'ENGINE=INNODB');
        
        $this->addForeignKey('vps_user_id_foreign_key', 'vps', 'user_id', 'user', 'id', 'CASCADE', 'NO ACTION');
        $this->addForeignKey('vps_server_id_foreign_key', 'vps', 'server_id', 'server', 'id', 'CASCADE', 'NO ACTION');
        $this->addForeignKey('vps_datastore_id_foreign_key', 'vps', 'datastore_id', 'datastore', 'id', 'CASCADE', 'NO ACTION');
        $this->addForeignKey('vps_os_id_foreign_key', 'vps', 'os_id', 'os', 'id', 'CASCADE', 'NO ACTION');
        $this->addForeignKey('vps_plan_id_foreign_key', 'vps', 'plan_id', 'plan', 'id', 'CASCADE', 'NO ACTION');
        
        // vps ips
        $this->createTable('vps_ip', [
            'id' => 'int(11) unsigned not null auto_increment PRIMARY KEY',
            'vps_id' => 'int(11) unsigned not null',
            'ip_id' => 'int(11) unsigned not null',
        ], 'ENGINE=INNODB');
        
        $this->addForeignKey('vps_ip_vps_id_foreign_key', 'vps_ip', 'vps_id', 'vps', 'id', 'CASCADE', 'NO ACTION');
        $this->addForeignKey('vps_ip_ip_id_foreign_key', 'vps_ip', 'ip_id', 'ip', 'id', 'CASCADE', 'NO ACTION');
        
        // vps actions histories
        $this->createTable('vps_action', [
            'id' => 'int(11) unsigned not null auto_increment PRIMARY KEY',
            'vps_id' => 'int(11) unsigned not null',
            'action' => 'tinyint(1) unsigned not null',
            'description' => $this->string(),
            'created_at' => 'int(11) unsigned not null',
        ], 'ENGINE=INNODB');
        
        $this->addForeignKey('vps_action_vps_id_foreign_key', 'vps_action', 'vps_id', 'vps', 'id', 'CASCADE', 'NO ACTION');
        
        // api
        $this->createTable('api', [
            'id' => 'int(11) unsigned not null auto_increment PRIMARY KEY',
            'key' => 'char(16) not null',
            'created_at' => 'int(11) unsigned not null',
            'updated_at' => 'int(11) unsigned not null',
        ], 'ENGINE=INNODB');
        
        $this->createIndex('api_key_unique_key', 'api', 'key', true);
        
        // api logs
        $this->createTable('api_log', [
            'id' => 'int(11) unsigned not null auto_increment PRIMARY KEY',
            'api_id' => 'int(11) unsigned not null',
            'action' => 'tinyint(1) unsigned not null',
            'description' => $this->string(),
            'created_at' => 'int(11) unsigned not null',
        ], 'ENGINE=INNODB');
        
        $this->addForeignKey('api_log_api_id', 'api_log', 'api_id', 'api', 'id', 'CASCADE', 'NO ACTION');
        
        // bandwidth
        $this->createTable('bandwidth', [
            'id' => 'int(11) unsigned not null auto_increment primary key',
            'vps_id' => 'int(11) unsigned not null',
            'used' => 'int(11) unsigned not null',
            'pure_used' => 'int(11) unsigned not null',
            'created_at' => 'int(11) unsigned not null',
			'status' => 'tinyint(1) unsigned not null default 1',
        ], 'ENGINE=INNODB');
        
        $this->addForeignKey('bandwidth_vps_id', 'bandwidth', 'vps_id', 'vps', 'id', 'CASCADE', 'NO ACTION');
    }

    public function down()
    {
        $this->dropTable('os');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
