#/bin/bash

case "$1" in
    start)
        docker-compose pull
        docker-compose up --build --remove-orphans -d
    ;;

    install)
        docker pull elnebuloso/composer:71
        docker run --rm -v $(pwd):$(pwd) -w $(pwd) -v composer_cache:/root/composer elnebuloso/composer:71 install
    ;;

    update)
        docker pull elnebuloso/composer:71
        docker run --rm -v $(pwd):$(pwd) -w $(pwd) -v composer_cache:/root/composer elnebuloso/composer:71 update
    ;;

    stop)
        docker-compose down --remove-orphans
    ;;

    *)
        clear
        echo ""
        echo "- start     Start all containers"
        echo "- install   Update PHP container sources"
        echo "- update    Update PHP container sources"
        echo "- stop      Stop all containers"
        echo ""
    ;;
esac