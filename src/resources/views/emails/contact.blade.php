<p>名前: {{ $contact->first_name }} {{ $contact->last_name }}</p>
<p>メールアドレス: {{ $contact->email }}</p>
<p>性別: {{ $contact->gender_text }}</p>
<p>電話: {{ $contact->tel }}</p>
<p>住所: {{ $contact->address }} {{ $contact->building }}</p>
<p>カテゴリ: {{ $contact->category->content }}</p>
<p>詳細: {{ $contact->detail }}</p>