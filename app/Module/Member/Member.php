<?php
declare(strict_types = 1);
namespace App\Module\Member;

use Nette;

final class Member 
{
    public const TABLE = "member";
    
    private Nette\Database\Explorer $_database;
    
    public function __construct(Nette\Database\Explorer $database)
    {
        $this->_database = $database;
    }
    
    public function newMember(string $fistname, string $lastname, int $role)
    {
        $table = self::TABLE;
        $this->_database->query(
            "INSERT INTO {$table}", 
            [
                'firstname' => $fistname,
                'lastname' => $lastname,
                'role_id' => $role,
            ]
        );
    }

    public function getMemberGridRows() : array
    {
        return $this->_database->table(self::TABLE)->joinWhere("role", "member.role_id = role.role_id")->select("member.*, role.label AS role_label")->order("member_id ASC")->fetchAll();
    }
    
    public function getMembersByRoleOptionArray(int $role_id) : array
    {
        $options = $this->_database->table(self::TABLE)->where("role_id = {$role_id}")->fetchAll();
        $option_array = [];
        
        foreach ($options as $option) {
            $option_array[$option->member_id] = $option->firstname . " " . $option->lastname;
        }
        
        return $option_array;
    }
}
