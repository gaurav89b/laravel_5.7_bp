Project Setup :
-Prerequisites
1) Install docker and docker compose (for mac users : https://docs.docker.com/docker-for-mac/install/#what-to-know-before-you-install)

-Steps:

1) run composer install
2) create these folders under storage/framework:
    sessions
    views
    cache
3) generate .env or copy .env.example to .env and populate required fields
4) cd docker
5) docker-compose up -d (this will run 4 containers i.e php, nginx, mysql and redis)
6) docker ps for list of running contianers
7) to enter in any container (docker exec -it 07f099fb4bc7 sh) where id is container id can be get from above command [mostly for running and artisan command or DB migration command, as db host will be valid in phpfpm container not in your host machine]
8) Or run it traditional way php artisan server



Additional Changes:
1) Default Project keyword is used. Change it to actual project name in .env file, swagger docs , api middleware.
2) Make neccessary changes in docker folder (name of services). i.e replace "sgbpapi" to your project name.
3) Check Port availability in docker-compose file [might be some port are already in use on your system]


Crud Generator:
1) This setup comes with crud generator crud:generator_view, Command usage is php artisan crud:generator_view Post (where Post is model name). This will generate skeleton views files, Model / Controller File and resources bundle. 
You have to make migration file by your own, also make changes in route file accordingly.
