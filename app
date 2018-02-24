#/bin/bash

case "$1" in
    create)
        clear
        docker build -t phing-commons --rm --pull -f Dockerfile .
    ;;

    verify)
        ./app create

        echo ""
        docker run -it --rm phing-commons php --version

        echo ""
        docker run -it --rm phing-commons docker --version

        echo ""
        docker run -it --rm phing-commons docker-compose --version

        echo ""
        docker run -it --rm phing-commons phing -version

        echo ""
        docker run -it --rm phing-commons phpcpd --version

        echo ""
        docker run -it --rm phing-commons pdepend --version

        echo ""
        docker run -it --rm phing-commons phploc --version

        echo ""
        docker run -it --rm phing-commons phpmd --version
    ;;

    *)
        echo ""
        echo " - create  create all containers"
        echo " - verify  verify all containers"
    ;;
esac