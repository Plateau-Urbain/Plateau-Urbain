set :stages,        %w(prod preprod)
set :default_stage, "preprod"
set :stage_dir,     app_config_path + "/capifony"

set :application, "plateau-urbain"


set :app_path,    "app"
set :use_sudo,    false
set :user,        "admin"

ssh_options[:port] = "22"
ssh_options[:forward_agent] = true


set :repository,  "git@github.com:widop/plateau-urbain.git"
set :scm,         :git
set :scm_verbose, true
set :deploy_via,  :remote_cache
# Or: `accurev`, `bzr`, `cvs`, `darcs`, `subversion`, `mercurial`, `perforce`, or `none`

set :model_manager, "doctrine"
# Or: `propel`

set :use_composer,               true
set :dump_assetic_assets,        true
set :update_assets_version,      true
set :normalize_asset_timestamps, false

set :upload_path,         web_path + "/uploads"
set :writable_dirs,       [ cache_path ]
set :permission_method,   :acl
set :use_set_permissions, true

#role :web,        domain                         # Your HTTP server, Apache/etc
#role :app,        domain, :primary => true       # This may be the same as your `Web` server

set :shared_files,    [ app_config_path + "/" + app_config_file ]
set :shared_children, [ log_path, upload_path, 'vendor' ]

set  :keep_releases,  3

#set :webserver_user, "www-data"

after "deploy", "deploy:cleanup"
after "deploy", "deploy:migrate"
after "deploy", "symfony:clear_apc"
after "deploy:rollback:cleanup", "symfony:clear_apc"


# Be more verbose by uncommenting the following line
logger.level = Logger::MAX_LEVEL
