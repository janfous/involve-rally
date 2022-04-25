<?php
declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;
use App\Module\Role\Role;
use App\Module\Member\Member;
use App\Module\Team\Team;

final class TeamPresenter extends Nette\Application\UI\Presenter
{
    const FORM_NAME = 'name';
    
    protected Role $_role;
    protected Member $_member;
    protected Team $_team;
    
    public function __construct(Role $role, Member $member, Team $team)
    {
        $this->_role = $role;
        $this->_member = $member;
        $this->_team = $team;
    }
        
    
    //GRID
    public function renderGrid() : void
    {   
        $this->template->teams = $this->_team->getTeamGridRows();
    }

    
    // FORM
    public function createComponentNewTeamForm() : Form
    {
        $form = new Form();
        $form->addText(self::FORM_NAME, "Team Name")->setRequired();
        $roles = $this->_role->fetchAll();
        foreach($roles as $role) {
            $this->_formAddMultiSelect($form, $role->name, $role->label, $role->role_id, $role->min, $role->max);
        }
        $form->addSubmit("submit", "Submit");
        $form->onSubmit[] = [$this, "formSubmit"];
        return $form;
    }
    
    private function _formAddMultiSelect(Form &$form, string $name, string $label, int $role_id, int $role_min, int $role_max) 
    {
        $member_array = $this->_member->getMembersByRoleOptionArray($role_id);
        $form->addHidden($name . "_max", $role_max);
        if ($role_min == 0) {
            $form->addMultiSelect($name, $label, $member_array);               
        } else {
            $form->addMultiSelect($name, $label, $member_array)->setRequired();
        }
    }
    
    public function formSubmit() : void 
    {
        $request = $this->request->post;
        $members_array = [];
        
        $roles = $this->_role->fetchAll();
        foreach($roles as $role) {
            $members_array = array_merge($members_array, $request[$role->name]);
        }
        
        $this->_team->newTeam($request[self::FORM_NAME], $members_array);
        $this->redirect("Homepage:default");
    }
}
