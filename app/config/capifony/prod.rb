set :domain,      "app.plateau-urbain.com"
set :deploy_to,   "/var/www/plateau-urbain"
set :branch, "master"
role :web, domain
role :app, domain, :primary => true
role :db,  domain, :primary => true
