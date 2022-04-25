<?php
declare(strict_types = 1);
namespace App\Module\Team;

use Nette;

final class Team
{
    const TABLE = "team";
    const TABLE_TEAM_MEMBER = "team_member";
    
    
    private Nette\Database\Explorer $_database;
    
    public function __construct(Nette\Database\Explorer $database)
    {
        $this->_database = $database;
    }
    
    public function getTeamGridRows() : array
    {
        /*$result = $this->_database->table("team_member")
            ->select("team.name AS team_name", "member.firstname", "member.lastname", "r.name AS role_name")
            ->joinWhere("team", "team.team_id = team_member.team_id")
            ->joinWhere("member", "team_member.member_id = member.member_id")
            ->joinWhere("role", "member.role_id = role.role_id")
            ->order("team.team_id ASC");
        */ 

        return $this->_database->query(
            <<<SQL
                SELECT team.team_id AS team_id, team.name AS team_name, member.firstname, member.lastname, role.label AS role_label
                	FROM team
                    JOIN team_member USING (team_id)
                    JOIN member USING (member_id)
                    JOIN role USING (role_id)
                    ORDER BY team.team_id ASC, role.role_id ASC
            SQL
            )->fetchAll();
    }
    
    public function newTeam(string $name, array $members_array) {
        $table = self::TABLE;
        $table_team_member = self::TABLE_TEAM_MEMBER;
        
        $this->_database->query(
            "INSERT INTO {$table}",
            [
                'name' => $name,
            ]
            );
        
        $last_id = $this->_database->getInsertId(self::TABLE);
        
        foreach ($members_array as $member_id) {
            $this->_database->query(
                "INSERT INTO {$table_team_member}",
                [
                    "team_id" => $last_id,
                    "member_id" => $member_id,
                ]
            );
            
        }
    }
    
}
