#opFileManagePlugin

ファイルを管理する

*this is 開発ちゅう*

##install
    $ php symfony opPlugin:install opFileManagePlugin -r 0.8.5  
    $ php symfony openpne:migrate --target=opFileManagePlugin  

または手動の場合は以下

    $ cd $openpne_dir/plugins  
    $ git clone https://github.com/amashigeseiji/opFileManagePlugin  
    $ cd opFileManagePlugin  
    $ git checkout 0.8.5  
    $ cd ../../  
    $ mysql -uroot $dbname -p -e "INSERT INTO sns_config (name, value) VALUES ('opFileManagePlugin_needs_data_load', '1');"  
    $ php symfony openpne:migrate --target=opFileManagedPlugin  
    $ php symfony plugin:publish-assets  

##機能
* ファイルのアップロード・ダウンロード  
* コミュニティ内でのファイル共有  
* プライベートフォルダの作成  

##使い方
* コミュニティ共有を利用する場合は、管理画面のプラグイン設定画面からopFileManagePluginの設定画面を表示し、Use Community Directory を Use にして保存してください。  
* プライベートフォルダを利用する場合は、管理画面のプラグイン設定画面からopFileManagePluginの設定画面を表示し、Use Private Directory を Use にして保存してください。  
