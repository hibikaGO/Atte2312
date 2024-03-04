# アプリケーション名：Atte
勤怠管理システム

## 作成目的
人事評価用

## アプリケーションURL


## 機能一覧
・ログイン機能  
・勤怠時間打刻機能  
・休憩時間打刻機能  
・ユーザ毎の日別勤怠時間一覧  

## 使用技術
Laravel 8.x  
Mysql 8.0.26  
PHP 8.2.11  

## テーブル設計
![Atte_table](https://github.com/hibikaGO/Atte2312/assets/145337159/b1267238-3712-4b86-9b62-f4ee693d39a7)

## ER図
![attendance](https://github.com/hibikaGO/Atte2312/assets/145337159/69a84d40-de03-492f-99d5-3564167cb02f)

## 環境構築
 Dockerビルド  
 
 1.git clone git@github.com:hibikaGO/Atte2312.git
 2.docker-compose up -d --build  

 Laravel環境構築  
 
 1.docker-conpose exec php bash  
 2.coposer install  
 3.env.exampleファイルから.envを作成しMysqlの環境変数を変更  
 4.php aritisan key:generate  
 5.php aritisan migrate  
 6.php artisan db:seed  
