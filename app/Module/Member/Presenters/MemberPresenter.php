<?php
declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;
use App\Module\Role\Role;
use App\Module\Member\Member;

final class MemberPresenter extends Nette\Application\UI\Presenter
{
    const FORM_FIRSTNAME = 'firstname';
    const FORM_LASTNAME = 'lastname';
    const FORM_ROLE = 'role';
    
    protected $_role;
    protected $_member;
    
    public function __construct(Role $role, Member $member)
    {
        $this->_role = $role;
        $this->_member = $member;
    }
        
    
    //GRID
    public function renderGrid() : void
    {   
        $this->template->members = $this->_member->getMemberGridRows();
    }

    
    // FORM
    public function createComponentNewMemberForm() : Form
    {
        $form = new Form();
        $form->addText(self::FORM_FIRSTNAME, "Firstname")->setRequired();
        $form->addText(self::FORM_LASTNAME, "Lastname")->setRequired();
        $form->addSelect(self::FORM_ROLE, "Role", $this->_role->getOptionArray())->setRequired();
        $form->addSubmit("submit", "Submit");
        $form->onSubmit[] = [$this, "formSubmit"];
        return $form;
    }
    
    public function formSubmit() : void 
    {
        $request = $this->request->post;
        $this->_member->newMember($request[self::FORM_FIRSTNAME], $request[self::FORM_LASTNAME], (int)$request[self::FORM_ROLE]);
        $this->redirect("Homepage:default");
    }
    
}
