#opFileManagePlugin

ファイルを管理する

*this is 開発ちゅう*

##install
    $ php symfony opPlugin:install opFileManagePlugin -r 0.8.0  

または手動の場合は以下

    $ cd $openpne_dir/plugins  
    $ git clone https://github.com/amashigeseiji/opFileManagePlugin  
    $ cd opFileManagePlugin  
    $ git checkout 0.8.0  
    $ cd ../../  
    $ mysql -uroot $dbname -p -e "INSERT INTO sns_config (name, value) VALUES ('opFileManagePlugin_needs_data_load', '1');"  
    $ php symfony openpne:migrate --target=opFileManagedPlugin  
    $ php symfony plugin:publish-assets  

##機能
* ファイルのアップロード・ダウンロード  
* コミュニティ内でのファイル共有  
