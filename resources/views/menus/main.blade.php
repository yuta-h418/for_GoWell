<div id="menuContent">
    <div id="menu_core">

        <p>こんにちは！</p>

        <h1>Purchase history</h1>

        <ul id="menu_list">
            <li>
                <a name="#" style="cursor:pointer;" onclick="location.href='/'">
                <img src="{{ asset('../img/home.svg') }}" alt="home">
                Topへ戻る
                </a>
            </li>
            <li>
                <a name="#" style="cursor:pointer;" onclick="location.href='/purchase_history'">
                <img src="{{ asset('../img/basket.svg') }}" alt="basket">
                購入履歴
                </a>
            </li>
            <li>
                <a name="#" style="cursor:pointer;" onclick="location.href='/'">
                <img src="{{ asset('../img/search.svg') }}" alt="search">
                購入履歴検索
                </a>
            </li>
            <li>
                <a name="#" style="cursor:pointer;" onclick="location.href='/form'">
                <img src="{{ asset('../img/register.svg') }}" alt="register">
                購入内容登録
                </a>
            </li>
            <li>
                <a name="#" style="cursor:pointer;" onclick="location.href='/'">
                <img src="{{ asset('../img/upload.svg') }}" alt="upload">
                購入内容アップロード
                </a>
            </li>
            <li>
                <a name="#" style="cursor:pointer;" onclick="location.href='/'">
                <img src="{{ asset('../img/logout.svg') }}" alt="upload">
                ログアウト
                </a>
            </li>
        </ul>

        <p>
            today:
            <span style="text-decoration:underline;">
               {{ \Carbon\Carbon::now()->format("Y/m/d") }} 
            </span>
        </p>

    </div>
</div>
