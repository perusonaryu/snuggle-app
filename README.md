
# snuggle

snuggleは猫を買いたい人、やむをえない事情により里親を探したい人、
今は猫が買えないが猫が好きな人を繋げるアプリです。

**[ポートフォリオURL](https://portfolio.snuggle-app.com/)**

## トップページ

<p align="center">
<img src="./README-images/toppage.png">
</p>

## 使用技術
* フロントエンド
    * HTML/CSS
    * JavaScript
    * vue.js
    * vuetify(UIフレームワーク)
    * Prettier(コード解析ツール)
    * pusher API

* バックエンド
    * php 7.3.22
    * Laravel 7.30.4

* インフラ
    * MySQL 5.7
    * Nginx
    * AWS(EC2,RDS,Route53,VPC)
    * Circle(CI/CD)

* テスト
    * phpunit

## ER図
<p align="center">
<img src="./README-images/snuggle-db.jpg">
</p>

## AWS構成図

<p align="center">
<img src="./README-images/snuggle-aws.jpg">
</p>

## 機能一覧
* 新規会員登録
* ログイン・ログアウト機能
* 簡単ログイン機能
* ユーザー情報編集機能
* 検索機能
* 猫お気に入り機能
* お気に入り一覧表示
* 猫登録機能
* 猫編集・削除機能
* 画像投稿機能
* リアルタイムチャット機能(pusher,LaravelEcho)


