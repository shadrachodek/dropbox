<?php

namespace App\Http\Livewire;

use App\Models\Obj;
use Livewire\Component;

class FileBrowser extends Component
{
    public $object;
    public $ancestors;
    public $creatingNewFolder = false;
    public $newFolderState = [
        'name' => ''
    ];

    public $renamingObjectState = [
        'name' => ''
    ];

    public $renamingObject;

    public function updatingRenamingObject($id) {

        if ($id === null) {
            $this->renamingObjectState = [
                'name' => null
            ];
        }


        if ($object = Obj::forCurrentTeam()->find($id)) {
            $this->renamingObjectState = [
                'name' => $object->objectable->name
            ];
        }
    }

    public function renameObject() {
        $this->validate([
            'renamingObjectState.name' => 'required|max:255'
        ]);
        Obj::forCurrentTeam()->find($this->renamingObject)->objectable->update($this->renamingObjectState);

        $this->object = $this->object->fresh();

        $this->renamingObjectState = null;
        $this->renamingObject = null;
    }

    public function createFolder() {
        $this->validate([
            'newFolderState.name' => 'required|max:255'
        ]);

        $object = $this->currentTeam->objects()->make([
            'parent_id' => $this->object->id
        ]);

        $object->objectable()->associate(
            $this->currentTeam->folders()->create($this->newFolderState)
        );

        $object->save();

        $this->creatingNewFolder = false;
        $this->newFolderState = [
            'name' => ''
        ];

        $this->object = $this->object->fresh();
    }

    public function getCurrentTeamProperty() {
        return auth()->user()->currentTeam;
    }

    public function render()
    {
        return view('livewire.file-browser');
    }
}
