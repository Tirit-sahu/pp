<div>
    <form wire:submit.prevent="UserCreate" method="POST">
        <input type="text" wire:model="name">
        <br><br>
        <button type="submit">Submit</button>
    </form>
</div>
