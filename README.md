# laravel-docker-template

# Laravel + Docker 開発環境テンプレート

## 📦 概要

Laravelの開発環境をDockerで構築するためのテンプレートです。
Laravel本体は `src` ディレクトリ内に含まれています。

### 構成

* nginx
* php (Laravel)
* MySQL
* phpMyAdmin

---

## 🚀 セットアップ手順

### ① コンテナ起動

```bash
docker compose up -d --build
```

---

### ② 依存関係インストール

```bash
docker compose exec php composer install
```

---

### ③ 環境ファイル作成

```bash
cp src/.env.example src/.env
```

---

### ④ アプリキー生成

```bash
docker compose exec php php artisan key:generate
```

---

### ⑤ マイグレーション

```bash
docker compose exec php php artisan migrate
```

---

## 🌐 アクセス

* アプリ: http://localhost
* phpMyAdmin: http://localhost:8080

---

## 🛠 DB設定（.env）

```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass
```

---

## 📁 ディレクトリ構成

```
.
├── docker
│   ├── nginx
│   ├── php
│   └── mysql
├── src（Laravel本体）
└── docker-compose.yml
```

---

## 🧹 よく使うコマンド

### 起動

```bash
docker compose up -d
```

### 停止

```bash
docker compose down
```

### コンテナに入る

```bash
docker compose exec php bash
```

### artisan

```bash
docker compose exec php php artisan
```

### composer

```bash
docker compose exec php composer install
```

---

## ⚠️ 注意点

* `.env` はGitに含めない
* `docker/mysql/data` はDBデータ保存用（Git管理しない）
* ポート80/8080が使用中だと起動できません
* 初回は `composer install` を必ず実行してください

---

## 🎯 このテンプレでできること

* Laravel開発環境を即構築
* Dockerで環境差分なし
* DB・phpMyAdmin込みのフル環境

---

## ✨ 補足

初回セットアップ完了後、
http://localhost にアクセスするとLaravelの画面が表示されます。
