#opFileManagePlugin

ファイルを管理する

*this is 開発ちゅう*

とりあえず動くようにするには以下

    $ cd $openpne_dir  
    $ mysql -uroot $dbname -p -e "INSERT INTO sns_config (name, value) VALUES ('opFileManagePlugin_needs_data_load', '1');"  
    $ php symfony openpne:migrate --target=opFileManagedPlugin  
    $ php symfony plugin:publish-assets  

