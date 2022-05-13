<div id="menuContent">
    <div id="menu_core">

        <p>こんにちは！</p>

        <h1>Purchase history</h1>

        <ul id="menu_list">
            <li>
                <a name="#" style="cursor:pointer;" onclick="location.href='/'">
                <img src="{{ asset('../img/home.svg') }}" alt="home">
                <span class="bold">Topへ戻る</span>
                </a>
            </li>
            <li>
                <a name="#" style="cursor:pointer;" onclick="location.href='/purchase_history'">
                <img src="{{ asset('../img/basket.svg') }}" alt="basket">
                <span class="bold">購入履歴</span>
                </a>
            </li>
            <li>
                <a name="#" style="cursor:pointer;" onclick="location.href='/'">
                <img src="{{ asset('../img/search.svg') }}" alt="search">
                <span class="bold">購入履歴検索</span>
                </a>
            </li>
            <li>
                <a name="#" style="cursor:pointer;" onclick="location.href='/form'">
                <img src="{{ asset('../img/register.svg') }}" alt="register">
                <span class="bold">購入内容登録</span>
                </a>
            </li>
            <li>
                <a name="#" style="cursor:pointer;" onclick="location.href='/'">
                <img src="{{ asset('../img/upload.svg') }}" alt="upload">
                <span class="bold">購入内容アップロード</span>
                </a>
            </li>
            <li>
                <a name="#" style="cursor:pointer;" onclick="location.href='/'">
                <img src="{{ asset('../img/logout.svg') }}" alt="upload">
                <span class="bold">ログアウト</span>
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
