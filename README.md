# phing-commons

## create your alias

```
alias phing="docker pull elnebuloso/phing-commons > /dev/null 2>&1 && docker run --rm -w \$(pwd) -v \$(pwd):\$(pwd) -v /var/run/docker.sock:/var/run/docker.sock elnebuloso/phing-commons phing \${@:1}"
```