<div>
    <button class="detail-button" wire:click="openModal" type="button">
        詳細
    </button>
    @if($showModal)
    <div class=" modal-backdrop" wire:click=" closeModal">
        <div class=" modal__content" wire:click.stop>
            <button class=" modal-close" wire:click=" closeModal">×</button>
            @if($selectedContact)
            <table class=" modal__inner">
                <tr class=" modal-table__row">
                    <th class=" modal-table__header">お名前</th>
                    <td class=" modal-table__item">{{ $selectedContact->last_name }} {{ $selectedContact->first_name }}</td>
                </tr>
                <tr class=" modal-table__row">
                    <th class=" modal-table__header">性別</th>
                    <td class=" modal-table__item">{{ $selectedContact->gender__text }} </td>
                </tr>
                <tr class=" modal-table__row">
                    <th class=" modal-table__header">メールアドレス</th>
                    <td class=" modal-table__item">{{ $selectedContact->email }} </td>
                </tr>
                <tr class=" modal-table__row">
                    <th class=" modal-table__header">電話番号</th>
                    <td class=" modal-table__item">{{ $selectedContact->tel }} </td>
                </tr>
                <tr class=" modal-table__row">
                    <th class=" modal-table__header">住所</th>
                    <td class=" modal-table__item">{{ $selectedContact->address }} </td>
                </tr>
                <tr class=" modal-table__row">
                    <th class=" modal-table__header">建物名</th>
                    <td class=" modal-table__item">{{ $selectedContact->building }} </td>
                </tr>
                <tr class=" modal-table__row">
                    <th class=" modal-table__header">お問い合わせの種類</th>
                    <td class=" modal-table__item">{{ $selectedContact->category->content }} </td>
                </tr>
                <tr class=" modal-table__row">
                    <th class=" modal-table__header">お問い合わせの内容</th>
                    <td class=" modal-table__item">{{ $selectedContact->detail }} </td>
                </tr>
            </table>
            <button class=" delete-button" wire:click=" deleteContact">削除</button>
            @endif
        </div>
    </div>
    @endif
</div>