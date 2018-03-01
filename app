#/bin/bash

case "$1" in
    create)
        echo ""
        docker build -t phing-commons --rm --pull -f Dockerfile .
    ;;

    verify)
        echo ""
        docker run -it --rm phing-commons php --version
        docker run -it --rm phing-commons docker --version
        docker run -it --rm phing-commons docker-compose --version
        docker run -it --rm phing-commons phing -version
        docker run -it --rm phing-commons phpcpd --version
        docker run -it --rm phing-commons pdepend --version
        docker run -it --rm phing-commons phploc --version
        docker run -it --rm phing-commons phpmd --version
    ;;

    phing)
        echo ""
        docker run --rm -w $(pwd)/test -v $(pwd)/test:$(pwd)/test -v /var/run/docker.sock:/var/run/docker.sock phing-commons phing ${@:2}
    ;;

    *)
        echo ""
        echo " - create  create all containers"
        echo " - verify  verify all containers"
        echo " - phing   phing demo project"
    ;;
esac