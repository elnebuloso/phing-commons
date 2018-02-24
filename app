#/bin/bash

case "$1" in
    create)
        clear
        docker build -t phing --rm --pull -f Dockerfile .
    ;;

    verify)
        ./app create

        echo ""
        docker run -it --rm phing php --version

        echo ""
        docker run -it --rm phing docker --version

        echo ""
        docker run -it --rm phing docker-compose --version

        echo ""
        docker run -it --rm phing phing -version

        echo ""
        docker run -it --rm phing phploc --version

        echo ""
        docker run -it --rm phing phpmd --version

        echo ""
        docker run -it --rm phing pdepend --version

        echo ""
        docker run -it --rm phing phpcpd --version
    ;;

    *)
        echo ""
        echo " - create  create all containers"
        echo " - verify  verify all containers"
    ;;
esac