Usar o seguinte comando para colocar o projeto acessível no pc

  git clone https://github.com/zlval-dev/integrity

Entrar na pasta do projeto e correr o comando

  docker-compose up --build
  
Abra um novo terminal, sem fechar o anterior pois esse é onde está a correr o projeto

Dentro da pasta corra os seguintes comandos

   docker exec -it php bash
  composer install
  
E o projeto está pronto a ser utilizado!

Comando para obter os headers, substituindo o <url> pelo url que pretende:
  
  php bin/console getheaders <url>
