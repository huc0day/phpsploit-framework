
在 index.php 文件中，新增 get_current_process_username 、get_current_file_owner_name 、current_process_username_is_current_file_owner_username 、is_file_executable_windows 、is_file_executable_unix 、check_file_executable 等方法，新增 /cli/create_token 、/cli/clear_token 等 路由条目 。

新增 Class_Controller_Cli.php 文件，优化 命令行环境的软件工具使用体验。

在 Class_Main.php 文件 中， 在 route_execute 方法 内，新增 对于 /cli/create_token 的 免 token 认证支持

在 Class_Operate_User.php 文件 中，新增 check_privilege_user_and_password_for_cli_create_token 方法。