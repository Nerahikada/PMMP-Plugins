# 説明
PMMPのプラグインの一覧  
僕が昔使っていたプラグインや[これら](http://pmwiki.tech/%E3%83%97%E3%83%A9%E3%82%B0%E3%82%A4%E3%83%B3%E7%B4%B9%E4%BB%8B)を今のバージョンに対応させたものです  
バージョンの対応のほかに、コードを変更しているプラグインもあります

<br>

## AlwaysSpawn
[**ダウンロード**](https://github.com/Nerahikada/PMMP-Plugins/releases/download/Plugins/AlwaysSpawn_v2.2.3.11.phar)  
[PocketMine Forums](https://forums.pocketmine.net/plugins/alwaysspawn.284/)  

プレイヤーがサーバーに参加すると、プレイヤーがスポーン地点にスポーンします


## BanItem
[**ダウンロード**](https://github.com/Nerahikada/PMMP-Plugins/releases/download/Plugins/BanItem_v2.2.11.phar)  
[Github](https://github.com/LDX-MCPE/BanItem)  
  
指定したアイテムを使用出来ないようにするプラグインです

| コマンド | 説明 |
| --- | --- |
|/banitem ban [アイテムID:メタ値]|指定したアイテムをBANします|
|/banitem unban [アイテムID:メタ値]|BANしたアイテムを再び使えるようにします|
|/banitem list|BANされたアイテムのリストを確認できます|


## dashjump
[**ダウンロード**](https://github.com/Nerahikada/PMMP-Plugins/releases/download/Plugins/dashjump_v1.1.11.phar)  
[MinecraftPE ForumUploader](http://uploader.mcpe.jp/detail?c=140)  
  
特定のブロックに乗ると前に飛びます

| コマンド | 説明 |
| --- | --- |
|/djb <ブロックID>|ダッシュするブロックを指定します|


## DevTools
[**ダウンロード**](https://github.com/Nerahikada/PMMP-Plugins/releases/download/Plugins/DevTools_v1.12.9.phar)  
[Github](https://github.com/pmmp/PocketMine-DevTools)  
  
プラグイン開発支援ツール  
フォルダープラグインを読み込んだりする際に必要となるプラグインです

| コマンド | 説明 |
| --- | --- |
|/makeserver|srcからPocketMine-MP.pharを作成します|
|/makeplugin <プラグインの名前>|プラグインのpharを作成します|
|/extractplugin <プラグインの名前>|phar形式のプラグインを解凍します|
|/genplugin <プラグインの名前> <作者名>|フォルダープラグインのテンプレートを作成します|
|/checkperm \<node\> [プレイヤーの名前]|(\<node\>は不明) 権限を確認します|


## FloatInfo
[**ダウンロード**](https://github.com/Nerahikada/PMMP-Plugins/releases/download/Plugins/FloatInfo_v1.0.11.1.phar)  

サーバーの情報が浮き文字で表示されます


## IPLogger
[**ダウンロード**](https://github.com/Nerahikada/PMMP-Plugins/releases/download/Plugins/IPLogger_v1.3.11.phar)  
[Github](https://github.com/PEMapModder/Small-ZC-Plugins/tree/master/IPLogger)  
  
サーバーにログインしたプレイヤーのIPを記録します

| コマンド | 説明 |
| --- | --- |
|/iplog <プレイヤーの名前>|プレイヤーのIPを確認します|


## JoinMessage
[**ダウンロード**](https://github.com/Nerahikada/PMMP-Plugins/releases/download/Plugins/JoinMessage_v1.0.11.phar)  

サーバーに入った時、指定したメッセージを送信します


## PocketMoney
[**ダウンロード**](https://github.com/Nerahikada/PMMP-Plugins/releases/download/Plugins/PocketMoney_v4.0.1.11.phar)  
[Github](https://github.com/MinecrafterJPN/PocketMoney)  
  
お金の要素を追加します

| コマンド | 説明 | 補足 |
| --- | --- | --- |
|/money|自分の持っているお金を確認します||
|/moeny help|コマンドの一覧を表示します||
|/money view <プレイヤー名>|プレイヤーの詳細を表示します||
|/money pay <プレイヤー名> <金額>|指定したプレイヤーにお金をあげます||
|/moeny top <数値>|<数値>までのランキングを表示します||
|/money stat|現在の経済状況を表示します||
|/money set <プレイヤー名> <金額>|指定したプレイヤーのお金を<金額>にセットします|コンソールからのみ使用可能です|
|/money hide <プレイヤー名>|指定したプレイヤーを非表示します||
|/money unhide <プレイヤー名>|指定したプレイヤーを再表示します||
