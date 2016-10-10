<?php

namespace Trog\Bundle\Admin\Page;

class EditPage
{
    public function configure()
    {
        $this->setTitle('Edit '.$this->object->getTitle());
        $this->add('actions', 'button.save');
        $this->add('actions', 'button.save_and_return');
        $this->add('actions', 'button.cancel', [
            'target' => $this->referralManager->getReferrerOr('trog_repository_browser'),
        ]);

        $this->add('status', new StatusWidget());
        $this->add('workflow', new WorkflowWidget());
    }
}
