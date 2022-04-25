<?php
declare(strict_types = 1);
namespace App\Module\Role;

use Nette;

final class Role 
{
    public const TABLE = "role";
    
    private Nette\Database\Explorer $_database;
    
    public function __construct(Nette\Database\Explorer $database)
    {
        $this->_database = $database;
    }

    public function getOptionArray() : array
    {
        $options = $this->_database->table(self::TABLE)->fetchAll();
        $option_array = [];
        
        /**
         * @var Nette\Database\Table\ActiveRow $option
         */
        foreach ($options as $option) {
            $option_array[$option->role_id] = $option->label; 
        }
        
        return $option_array;
    }
    
    public function fetchAll() {
        return $this->_database->table(self::TABLE)->fetchAll();
    }
}
