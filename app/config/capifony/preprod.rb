set :domain,      "plateau-urbain.widop.com"
set :deploy_to,   "/var/www/plateau-urbain"
set :branch, "release/0.1.0"
role :web, domain
role :app, domain, :primary => true
role :db,  domain, :primary => true
