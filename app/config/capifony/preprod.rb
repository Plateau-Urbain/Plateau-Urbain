set :domain,      "plateau-urbain.widop.com"
set :deploy_to,   "/var/www/plateau-urbain"
set :branch, "develop"
role :web, domain
role :app, domain, :primary => true
role :db,  domain, :primary => true
