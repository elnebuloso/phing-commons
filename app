#/bin/bash

case "$1" in
    start)
        sh ./app start.php56
        sh ./app start.php70
        sh ./app start.php71
    ;;

    start.php56)
        docker-compose pull
        docker-compose up --build --remove-orphans -d php56
    ;;

    start.php70)
        docker-compose pull
        docker-compose up --build --remove-orphans -d php70
    ;;

    start.php71)
        docker-compose pull
        docker-compose up --build --remove-orphans -d php71
    ;;

    update.php56)
        docker-compose run php56 bash -c 'cd /opt/phing-commons; composer update'
    ;;

    update.php70)
        docker-compose run php70 bash -c 'cd /opt/phing-commons; composer update'
    ;;

    update.php71)
        docker-compose run php71 bash -c 'cd /opt/phing-commons; composer update'
    ;;

    stop)
        docker-compose down --remove-orphans
    ;;

    *)
        clear
        echo ""
        echo "- start           Start all containers"
        echo "- start.php56     Start PHP 5.6 container"
        echo "- start.php70     Start PHP 7.0 container"
        echo "- start.php71     Start PHP 7.1 container"
        echo "- update.php56    Update PHP 5.6 container sources"
        echo "- update.php70    Update PHP 7.0 container sources"
        echo "- update.php71    Update PHP 7.1 container sources"
        echo ""
    ;;
esac