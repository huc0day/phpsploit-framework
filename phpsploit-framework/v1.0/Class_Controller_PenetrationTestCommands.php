<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 23-7-5
 * Time: 下午9:23
 */

/*
=======================================================================================================
Phpsploit-Framework is an open source CTF framework and vulnerability exploitation development library.
Copyright (C) 2022-2023, huc0day (Chinese name: GaoJian).
All rights reserved.

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY;   without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.    See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.    If not, see <https://www.gnu.org/licenses/>.
=======================================================================================================
 */

class Class_Controller_PenetrationTestCommands extends Class_Controller
{
    private static function _commands_format_to_form_inputs($commands, &$form)
    {
        foreach ($commands as $module_key => $module_item) {
            foreach ($module_item as $command_key => $command_item) {
                $form["inputs"][] = array(
                    "id" => "key_id_" . $command_key,
                    "title" => $command_item["title"],
                    "describe" => $command_item["describe"],
                    "value" => $command_item["command"],
                    "disabled" => "disabled",
                );
                foreach ($command_item["examples"] as $index => $example_info) {
                    $form["inputs"][] = array(
                        "id" => "examples_id_" . $command_key,
                        "title" => $example_info["title"],
                        "describe" => $example_info["describe"],
                        "value" => $example_info["command"],
                        "disabled" => "disabled",
                    );
                }
            }
        }
    }

    private static function _commands_format_to_form_textareas($commands, &$form)
    {
        foreach ($commands as $module_key => $module_item) {

            foreach ($module_item as $command_key => $command_item) {
                $_textarea_value = ("\n\n" . "command : " . $command_item["command"] . "\n");
                $_textarea_value .= ("\n\n" . "describe : " . $command_item["describe"] . "\n");
                if ((!empty($command_item["examples"])) && (is_array($command_item["examples"]))) {
                    $_textarea_value .= ("\n" . "examples : ");
                    foreach ($command_item["examples"] as $index => $example_info) {
                        if ($index != 0) {
                            $_textarea_value .= ("\n");
                            $_textarea_value .= ("           ");
                        }
                        $_textarea_value .= (($example_info["command"]) . (" ") . ("#" . $example_info["describe"]) . "\n");

                    }
                }
                $form["textareas"][] = array(
                    "id" => "key_id_" . $command_key,
                    "title" => ((!isset($command_item["title"])) ? ("") : ($command_item["title"])),
                    "describe" => ((!isset($command_item["describe"])) ? ("") : ($command_item["describe"])),
                    "value" => $_textarea_value,
                    "disabled" => "disabled",
                    "style" => ((!isset($command_item["style"])) ? ("") : ($command_item["style"])),
                );
            }
        }
    }

    public static function index ( $params = array () )
    {
        if ( ( ! is_cli () ) && ( ! Class_Base_Auth::is_login () ) ) {
            Class_Base_Response::redirect ( "/login" );
            return null;
        }
        Class_Base_Auth::check_permission ();
        if ( ! is_cli () ) {
            $_top    = Class_View_Top::top ();
            $_body   = array (
                "menu"    => Class_View_Guide_PenetrationTestCommands_Menu::menu()  ,
                "content" => '<div style="width:100%;padding-top:64px;padding-bottom:64px;text-align: center;font-size:32px;">Disclaimers</div>
<div>

<div style="text-align: left;padding-top:16px;padding-bottom:16px;">The introduction module of this penetration testing command (/guide/generation_test_commands) and all related content published by its sub modules, including text, images, audio, video, software, programs, and webpage layout design, are collected online;</div>

<div style="text-align: left;padding-top:16px;padding-bottom:16px;">This infiltration command introduces the module (/guide/generation_test_commands) and all the content provided by its sub modules for personal learning, research, or appreciation only. The author of this software does not guarantee the accuracy of the content. The risks associated with using this penetration testing command to introduce the module (/guide/generation_test_commands) and all its sub modules are not related to the author of this software!</div>

<div style="text-align: left;padding-top:16px;padding-bottom:16px;">This penetration testing command introduction module (/guide/generation_test_commands) and all its sub modules contain some content that is automatically generated by translation software (manually translating all content will be a challenging task, and I am currently translating it myself). In addition, due to my limited foreign language proficiency, there may be errors and differences in my understanding of the content. I do not assume any responsibility for any understanding or cognitive errors caused to you due to translation errors and any adverse consequences arising therefrom. You should refer to the official manual of the relevant tool software for the most accurate explanation and answer. If you find any errors in the content of this penetration testing command introduction module (/guide/generation_test_commands) and all its sub modules, please feel free to contact me in a timely manner. After verifying the error situation, I will correct the corresponding error content as soon as possible. I sincerely appreciate your support!</div>

<div style="text-align: left;padding-top:16px;padding-bottom:16px;">Visitors to this penetration testing command introduction module (/guide/generation_test_commands) and all its sub modules (sometimes referred to as "visitors" in the following content) can use the content provided by this penetration testing command introduction module (/guide/generation_test_commands) and all its sub modules for personal learning, research, or appreciation, as well as other non commercial or non-profit legitimate purposes. Visitors should comply with domestic laws and regulations and not use the content of this penetration testing introduction module (/guide/Generation_Test_commands) and all its sub modules for any illegal purpose! If the visitor causes any loss or impact to any third party due to improper use of the content provided by the introduction module (/guide/generation_test_commands) and all sub modules of this penetration test command or other personal reasons, the visitor shall bear the consequences themselves. The author of this software assumes no responsibility.</div>

<div style="text-align: left;padding-top:16px;padding-bottom:16px;">If the original author of the relevant command content covered in this penetration test command introduction module (/guide/generation_test_commands) and all its submodules does not want this penetration test command introduction module (/guide/generation_test_commands) and all its submodules The module contains relevant command content, please inform the software author in time, the software author will delete the relevant content.</div>

</div>' ,
            );
            $_bottom = Class_View_Bottom::bottom ();
            Class_Base_Response::output ( Class_View::index ( $_top , $_body , $_bottom ) , "text" , 0 );
        }
        return null;
    }

    public static function information_gathering($params = array())
    {
        if ((!is_cli()) && (!Class_Base_Auth::is_login())) {
            Class_Base_Response::redirect("/login");
            return null;
        }
        Class_Base_Auth::check_permission();
        $_common_commands = array(
            "information_gathering" => array(
                "dmitry" => array(
                    "title" => 'dmitry : ',
                    "describe" => '深度信息收集工具（参数选项：
                    
-o        将输出内容保存到主机信息文件（ %host.txt ）（或将输出内容保存到以参数选项 -o 指定的文本文件）；

-i        对目标主机的IP地址进行 whois 查询；

-w        对目标主机的域名执行 whois 查询；

-n        在 Netcraft.com 网站中搜索目标主机信息；

-s        要进行搜索的子域；

-e        查询存在的电子邮件地址；

-p        在目标主机上执行基于TCP协议的端口扫描行为；

-f        在显示输出报告过滤端口的目标主机上执行基于TCP协议的端口扫描行为（需要附加传递参数选项 -p ）；

-b        读取从扫描端口中接收到的banner（需要附加传递参数选项 -p ）；

-t        设置扫描 TCP 端口时的 TTL 值（取值范围： 0～9 ， 默认值为 2 ）（需要附加传递参数选项 -p ）
         
                    ）',
                    "command" => 'dmitry [-winsepfb] [-t 0-9] [-o %host.txt] host ',
                    "examples" => array(
                        array(
                            "title" => "",
                            "describe" => "对目标主机执行端口扫描行为",
                            "command" => "dmitry -p <IP地址>",
                        ),
                        array(
                            "title" => "",
                            "describe" => "对目标主机的IP地址执行whois查询行为",
                            "command" => "dmitry -i <IP地址>",
                        ),
                        array(
                            "title" => "",
                            "describe" => "对目标主机的域名执行whois查询行为",
                            "command" => "dmitry -w <域名>",
                        ),
                    ),
                ),
                "ike-scan" => array(
                    "title" => 'ike-scan : ',
                    "describe" => 'VPN服务嗅探工具（参数选项：
                    
--help 或-h 显示帮助信息；

--file = <指定文件的绝对路径>或 -f <指定文件的绝对路径> 从指定文件中读取域名或IP地址信息（文件内容格式：每行一个域名或IP地址，以字符 ”-“ 作为标准输入）；

--sport = <源UDP端口> 或 -s <源UDP端口> 设置VPN客户端的UDP端口为指定端口（默认值为500，0=随机值），将指定进程绑定到源UDP端口时，可使用--nat-t选项进行更改（默认源端口为4500）；

--dport = <目标UDP端口>或 -d <目标UDP端口> 将UDP的目标端口设置为指定端口（默认值为500），可使用--nat-t选项更改目标端口（默认目标端口为4500）；

--retry = <重试次数>或 -r <重试次数> 设置目标主机的重试次数（默认值为3）。

--timeout = <毫秒数>或 -t <毫秒数> 设置目标主机的超时时间（单位为毫秒，默认为500毫秒）（此超时设置影响发送到目标主机的首个数据包，随后的数据包的超时秒数将乘以回退系数，设置为--backoff）；

--bandwidth = <每秒传输的比特位数（bits）>或-B <每秒传输的比特位数（bits）> 设置发送带宽（默认值 56000 比特（bit），可选值为 位（bit） 、千比特（K）、兆比特（M），1千比特=1000bit)；

--interval = <n>或-i <n>  设置发送数据包的最小时间间隔（单位为毫秒（ms）,如果附加 u 字符，则单位为微秒，如果附加 s 字符，则单位为秒）（--bandwidth选项 与 --interval 选项不能同时使用），分组发送的时间间隔不会小于发送数据包的最小时间间隔；

--backoff = <超时退避因子> 或-b <超时退避因子> 将超时退避因子设置为指定值（默认为1.50）（每个超时等于上一个超时将乘以超时退避因子，超时值的计算与重试次数支持挂钩）；

--verbose 或-v 显示详细的进度信息（可取值：1～3）；
    
- multiline 或 -M 分割多行的有效载荷解码；
    
--lifetime = <秒数>或 -l <秒数> 将IKE生存期设置为指定秒数（默认为28800秒）（可以使用--trans选项来产生多个变换有效载荷且具有不同的生命周期值，每个--trans选项将使用之前指定的生命周期值）；

--lifesize = <s> 或-z <s> 将IKE大小设置为千字节（默认值为0）；

--auth = <身份验证的方式值> 或-m <身份验证的方式值> 设置身份验证方式（默认值为 1 ，采用 PSK 方式，可取值为1～5，可参考 RFC 2409附录A ）；

--version 或-V 显示软件版本信息；

--vendor = <十六进制值>或-e <十六进制值> 将供应商的ID字符串内容设置为指定的十六进制值
                    
                    ）',
                    "command" => 'ike-scan <参数选项> <IP地址或域名>',
                    "examples" => array(
                        array(
                            "title" => "",
                            "describe" => "根据IP地址嗅探目标主机的VPN服务",
                            "command" => "ike-scan <IP地址>",
                        ),
                        array(
                            "title" => "",
                            "describe" => "根据域名嗅探目标主机的VPN服务",
                            "command" => "ike-scan <域名>",
                        ),
                    ),
                ),
                "legion（root）" => array(
                    "title" => 'legion（root） : ',
                    "describe" => '自动枚举工具（图形化工具）',
                    "command" => 'legion',
                    "examples" => array(),
                ),
                "netdiscover" => array(
                    "title" => 'netdiscover : ',
                    "describe" => '探测局域网中的存活主机信息（参数选项：

-i <网卡接口>：指定网卡接口；

-r <网段范围>：扫描给定的网段范围（如 192.168.1.0/24 ）；

-l <扫描范围的列表文件>：指定扫描范围的列表文件；

-p 被动模式：不发送任何内容，只进行嗅探操作；

-m <已知MAC和主机名的扫描列表文件>：指定包含已知MAC和主机名的扫描列表；

-F <过滤器名称>：自定义pcap过滤器的表达式（默认值为 arp）；

-s <毫秒数>：每个ARP请求之间的睡眠时间（毫秒）；

-c <发送相同ARP请求的次数>：发送每个ARP请求的次数（对于丢失数据包的网络）；

-n <IPV4地址的最后一段数字>：用于扫描的最后一个源IP八位字节（从2到253）；

-d 忽略自动扫描和快速模式的主配置文件；

-f 启用快速模式扫描，节省大量时间，建议用于自动；

-P 打印结果的格式适合由另一个程序解析，并在活动扫描后停止；

-L 类似于-P，但在活动扫描完成后继续侦听；

-N 不打印页眉。仅在启用-P或-L时有效；

-S 启用每次请求之间的睡眠时间抑制（核心模式）；

如果-r、-l或-p未启用，则netdiscover将进行扫描公共LAN地址。 
                    
                    ）',
                    "command" => 'netdiscover [-i <网络接口名称>] [-r <网段地址范围>|-l <扫描范围文件>|-p] [-m <已知MAC和主机名的扫描列表文件>] [-F <过滤器名称>] [-s <毫秒数>] [-c <发送相同ARP请求的次数>] [-n <IPV4地址的最后一段数字>] [-dfPLNS] ',
                    "examples" => array(
                        array(
                            "title" => "",
                            "describe" => "使用指定网卡扫描192.168.1.0网段下的存活主机（当前C类网段最多可容纳254台主机）",
                            "command" => "netdiscover -i <网络接口名称> -r 192.168.1.0/24",
                        ),
                    ),
                ),
                "p0f" => array(
                    "title" => 'p0f : ',
                    "describe" => '操作系统指纹识别工具（参数选项：
                    
网络接口选项：

  -i <网络接口名称>         在指定的网络接口上侦听；
  
  -r <指定文件的绝对路径>   从给定文件中读取脱机pcap数据；
  
  -p                       将侦听接口置于混杂模式；
  
  -L                       列出所有可用接口；
  

操作模式和输出设置：

  -f <指定文件的绝对路径>   从“file”（/etc/p0f/p0f.fp）读取指纹数据库；
  
  -o <指定文件的绝对路径>   将信息写入指定的日志文件；
  
  -s <套接字名称>          在命名的unix套接字上对API查询的回答；
  
  -u <指定账户名称>        切换到指定的无特权帐户并chroot；
  
  -d                       分叉到后台（需要-o或-s）；
  

性能相关选项：

  -S <限制数量>               API并行连接的限制数量（20）；
  
  -t <限制时间>,<限制时间>    设置连接/主机缓存使用期限限制（30s，120m）；
  
  -m <限制数量>,<限制数量>    限制活动连接/主机的数量（1000，10000）；
  
  
可以在命令中指定可选的筛选器表达式（man-tcpdump）线路，以防止p0f查看附带的网络流量。
                    
                    ）',
                    "command" => 'p0f -i <网络接口名称> –p',
                    "examples" => array(
                        array(
                            "title" => "",
                            "describe" => "监听指定网络接口，同时开启混杂模式",
                            "command" => "p0f -i <网络接口名称> –p",
                        ),
                    ),
                ),
                "nmap" => array(
                    "title" => 'nmap : ',
                    "describe" => '网络扫描与嗅探工具',
                    "command" => 'nmap <ip地址>',
                    "examples" => array(
                        array(
                            "title" => "",
                            "describe" => "查看软件的帮助信息",
                            "command" => "nmap -h",
                        ),
                        array(
                            "title" => "",
                            "describe" => "检测目标主机指定端口号的开放状态",
                            "command" => "nmap <ip地址> -p <端口号>",
                        ),
                        array(
                            "title" => "",
                            "describe" => "检测目标主机指定范围内全部端口号的开放状态",
                            "command" => "nmap <ip地址> -p <起始端口号>-<结束端口号>",
                        ),
                        array(
                            "title" => "",
                            "describe" => "检测目标主机指定范围内全部端口号的开放状态",
                            "command" => "nmap <ip地址> -p <端口号列表，以 逗号“,”作为分隔符>",
                        ),
                        array(
                            "title" => "",
                            "describe" => "检测目标主机全部端口号的开放状态",
                            "command" => "nmap <ip地址> -p -",
                        ),

                        array(
                            "title" => "",
                            "describe" => "以TCP全连接方式对目标主机进行端口扫描（使用完整的三次握手方式建立通信连接，连接成功，则一般情况下，代表端口处于开放状态）",
                            "command" => "nmap <ip地址> -sT",
                        ),
                        array(
                            "title" => "",
                            "describe" => "以TCP半连接方式对目标主机进行端口扫描（仅进行两次通信握手，应答方返回确认帧（ACK=1），则一般情况下，代表端口处于开放状态）",
                            "command" => "nmap <ip地址> -sS",
                        ),
                        array(
                            "title" => "",
                            "describe" => "以Fin方式对目标主机进行端口扫描（隐秘扫描方式，向目标主机的端口发送TCP FIN包，收到目标主机返回的RST响应包，则一般情况下，代表端口处于关闭状态！否则，目标端口可能处于开放（open）或屏蔽（filtered）状态）",
                            "command" => "nmap <ip地址> -sF",
                        ),
                        array(
                            "title" => "",
                            "describe" => "以Null方式（（向目标主机发送全部标志位（flags）均为0的TCP数据包））对目标主机进行端口扫描（隐秘扫描方式，向目标主机的端口发送Null包，收到目标主机返回的RST响应包，则一般情况下，代表端口处于关闭状态！否则，目标端口可能处于开放（open）或屏蔽（filtered）状态））",
                            "command" => "nmap <ip地址> -sN",
                        ),
                        array(
                            "title" => "",
                            "describe" => "以Xmas方式（（向目标主机发送FIN标志位、URG标志位、PUSH标志位均为1的TCP数据包））对目标主机进行端口扫描（隐秘扫描方式，向目标主机的端口发送Xmas tree包，收到目标主机返回的RST响应包，则一般情况下，代表端口处于关闭状态！否则，目标端口可能处于开放（open）或屏蔽（filtered）状态））",
                            "command" => "nmap <ip地址> -sX",
                        ),
                        array(
                            "title" => "",
                            "describe" => "对目标主机进行存活探测（以ping方式（icmp请求+icmp回显的通信方式）进行主机存活探测，能接收到来自目标主机的icmp回显数据包，则一般情况下，代表目标主机存活）",
                            "command" => "nmap <ip地址> -sP",
                        ),
                        array(
                            "title" => "",
                            "describe" => "对目标主机进行服务识别",
                            "command" => "nmap <ip地址> -sV",
                        ),
                        array(
                            "title" => "",
                            "describe" => "对目标主机进行系统识别",
                            "command" => "nmap <ip地址> -sP",
                        ),

                        array(
                            "title" => "",
                            "describe" => "以文本格式（txt）导出扫描结果",
                            "command" => "nmap <ip地址> -oN <文本文件的绝对路径>",
                        ),
                        array(
                            "title" => "",
                            "describe" => "以可扩展标记语言格式（xml）导出扫描结果",
                            "command" => "nmap <ip地址> -oX <xml文件的绝对路径>",
                        ),
                    ),
                ),
                "recon-ng" => array(
                    "title" => 'recon-ng : ',
                    "describe" => '信息收集框架（使用 regon-ng 工具，有时需要使用代理方式，是否需要使用代理方式，一定程度上取决于您当前所处的网络环境。注意，使用代理方式，可能会存在一定安全风险！例如：网络通信数据被恶意的代理服务器劫持、窃取和恶意利用等！代理程序的安装命令为 aptitude install proxychains ，您可能需要编辑代理程序的配置文件（vim /etc/proxychains.conf）（注意，在不同系统环境中，proxychains 工具的配置文件路径可能会有所不同） ， 并在文件内容末尾添加指定格式内容： socks5 127.0.0.1 <代理环境的本地监听端口>）（如您的网络环境无法直接访问regon-ng 工具的官方资源，同时您也不愿使用代理方式访问regon-ng 工具的官方资源，您也可以酌情考虑从github平台下载相关文件（git clone https://github.com/lanmaster53/recon-ng-marketplace.git）。注意，由于相关文件来源于第三方，因此可能会存在一定的安全风险！您需自行鉴别相关文件的安全性与正确性等情况，并自行决定是否进行相关文件的下载与引用）（在线文档 https://www.blackhillsinfosec.com/wp-content/uploads/2019/11/recon-ng-5.x-cheat-sheet-Sheet1-1.pdf 来源于第三方，它记录了 Recon-ng 5.1版本 较之前版本的一些变化）',
                    "command" => 'recon-ng 或 proxychains recon-ng',
                    "examples" => array(
                        array(
                            "title" => "",
                            "describe" => "创建一个新的工作区",
                            "command" => "recon-ng -w <工作区名称>",
                        ),
                        array(
                            "title" => "",
                            "describe" => "查看帮助信息",
                            "command" => "help",
                        ),
                        array(
                            "title" => "",
                            "describe" => "退出recon-ng软件",
                            "command" => "exit",
                        ),
                        array(
                            "title" => "",
                            "describe" => "返回到上一层",
                            "command" => "back",
                        ),
                        array(
                            "title" => "",
                            "describe" => "显示概要",
                            "command" => "dashboard",
                        ),
                        array(
                            "title" => "",
                            "describe" => "数据库接口",
                            "command" => "db <insert/delete/query/schema/notes> companies",
                        ),
                        array(
                            "title" => "",
                            "describe" => "查看全部的模块索引",
                            "command" => "index all",
                        ),
                        array(
                            "title" => "",
                            "describe" => "查看全部的第三方凭证",
                            "command" => "keys list",
                        ),
                        array(
                            "title" => "",
                            "describe" => "添加指定的第三方凭证",
                            "command" => "keys add <凭证名称> <凭证内容>",
                        ),
                        array(
                            "title" => "",
                            "describe" => "删除指定的第三方凭证",
                            "command" => "keys remove <凭证名称>",
                        ),
                        array(
                            "title" => "",
                            "describe" => "显示全部模块的相关信息",
                            "command" => "marketplace info all",
                        ),
                        array(
                            "title" => "",
                            "describe" => "显示模块列表",
                            "command" => "marketplace search",
                        ),
                        array(
                            "title" => "",
                            "describe" => "刷新模块接口",
                            "command" => "marketplace refresh",
                        ),
                        array(
                            "title" => "",
                            "describe" => "安装全部模块",
                            "command" => "marketplace install all",
                        ),
                        array(
                            "title" => "",
                            "describe" => "搜索指定模块",
                            "command" => "marketplace search <模块名称>",
                        ),
                        array(
                            "title" => "",
                            "describe" => "安装指定模块",
                            "command" => "marketplace install <模块路径>",
                        ),
                        array(
                            "title" => "",
                            "describe" => "管理指定模块",
                            "command" => "modules <load/reload/search> <模块路径>",
                        ),
                        array(
                            "title" => "",
                            "describe" => "查看模块的配置信息",
                            "command" => "info",
                        ),
                        array(
                            "title" => "",
                            "describe" => "查看模块配置中的全部变量内容",
                            "command" => "options list",
                        ),
                        array(
                            "title" => "",
                            "describe" => "更新模块配置中的指定变量的内容",
                            "command" => "options set <模块变量名称> <模块变量内容>",
                        ),
                        array(
                            "title" => "",
                            "describe" => "清空模块配置中的指定变量的内容",
                            "command" => "options unset <模块变量名称> <模块变量内容>",
                        ),
                        array(
                            "title" => "",
                            "describe" => "执行模块内容",
                            "command" => "run",
                        ),
                        array(
                            "title" => "",
                            "describe" => "启动内置的python",
                            "command" => "pdb",
                        ),
                        array(
                            "title" => "",
                            "describe" => "记录并执行命令脚本",
                            "command" => "srcipt <<record [filename]>/<execute [filename]>/stop/status>",
                        ),
                        array(
                            "title" => "",
                            "describe" => "执行shell命令",
                            "command" => "shell <指定命令>",
                        ),
                        array(
                            "title" => "",
                            "describe" => "查看各类框架模块的相应内容",
                            "command" => "show <companies|contacts|credentials|domains|hosts|leaks|locations|netblocks|ports|profiles|pushpins|repositories|vulnerabilities>",
                        ),
                        array(
                            "title" => "",
                            "describe" => "管理工作区快照",
                            "command" => "snapshots <take/remove/list/<load [snapshot_name]>>",
                        ),
                        array(
                            "title" => "",
                            "describe" => "输出到文件",
                            "command" => "spool <<start [filename]>/stop/status>",
                        ),
                        array(
                            "title" => "",
                            "describe" => "管理工作区",
                            "command" => "workspaces <create/load/list/remove>",
                        ),
                        array(
                            "title" => "",
                            "describe" => "项目的官方地址",
                            "command" => "https://github.com/lanmaster53/recon-ng",
                        ),
                        array(
                            "title" => "",
                            "describe" => "故障排除的官方说明页",
                            "command" => "https://github.com/lanmaster53/recon-ng/wiki/Troubleshooting#issue-reporting",
                        ),
                    ),
                ),
                "altdns" => array(
                    "title" => 'altdns : ',
                    "describe" => '子域名信息枚举工具（参数选项：

  -h 或 --help    查看帮助信息
  
  -i <子域列表> 或 --input <子域列表>    输入子域列表
  
  -o <子域输出位置> 或 --output <子域输出位置>    更改子域的输出位置
  
  -w <子域关键词列表> 或 --wordlist <子域关键词列表>  更改子域的关键词列表
  
  -r 或 --resolve  解析所有更改的子域
  
  -n 或 --add-number-suffix  为每个域添加数字后缀（0-9）
  
  -e 或 --ignore-existing  忽略文件中的现有域
  
  -d <DNS服务器的IP地址> 或 --dnsserver <DNS服务器的IP地址>  指定 altdns 软件使用的DNS服务器IP地址（会覆盖系统默认值）
  
  -s <指定保存结果文件> 或 --save <指定保存结果文件>  要将解析的更改子域保存到的文件
  
  -t <同时运行的线程数量> 或 --threads <同时运行的线程数量>  要同时运行的线程数 
                      
                    ）',
                    "command" => 'altdns [-h] -i INPUT -o OUTPUT [-w WORDLIST] [-r] [-n] [-e] [-d DNSSERVER] [-s SAVE] [-t THREADS]',
                    "examples" => array(),

                ),
                "spiderfoot" => array(
                    "title" => 'spiderfoot : ',
                    "describe" => '网站信息收集工具（参数选项：
                            
-h --help 显示帮助信息；

-d --debug 启用调试输出；

-l 监听本地的指定IP与指定端口（如 127.0.0.1：5003）；

-m <指定模块> 启用指定的功能模块（如果启用多个功能模块，则模块名称之间用逗号","分隔）；

-M  --modules 列出当前的可用模块列表；

-C  --correlate <关联扫描的ID> 指定关联的扫描ID（通过指定关联的扫描ID，可以使用扫描ID对应的扫描规则） ；

-s <扫描的目标> 指定要扫描的目标；

-t <要收集信息的指定事件类型> 指定要收集信息的事件类型（自动选择的模块）（如果指定多个事件类型，则事件类型名称之间用逗号","分隔）；

-u ｛所有（all），足迹（footprint），调查（investigate），被动（passive）｝；

根据用例自动选择模块；

-T --types 列出可用的事件类型；

-o ｛tab，csv，json｝指定扫描结果的输出格式（tab，csv，json）（默认格式为tab）；

-H 不进行字段标题的打印，仅进行数据的打印；

-n 从数据中删除换行符；

-r 在以tab或csv格式进行输出的内容中包含源数据字段内容；

-S <数据长度> 指定要显示的最大数据长度（默认为显示所有数据）；

-D 指定用于CSV格式内容输出的分隔符；

-f 筛选出未使用 -t 请求的其他事件类型；

-F <事件类型> 显示指定的事件类型（多个事件类型名称之间，使用逗号","进行分隔）；

-x 严格模式（仅启用可以有效使用的功能模块！当在严格模式下，被成功启用的功能模块与参数选项 -t 与 -m 设置的内容存在冲突情况时，参数选项 -t 和 -m 设置的内容将失效！）；

-q 禁用日志记录（注意，这可能将使您无法及时发现软件运行时出现的异常情况！）；

-V --version 显示软件版本信息；

-max-threads <最大线程数量> 指定当前软件进程可同时运行的功能模块数量
                            
                            ）',
                    "command" => 'spiderfoot [-h] [-d] [-l IP:port] [-m mod1,mod2,...] [-M] [-C scanID] [-s TARGET] [-t type1,type2,...] [-u {all,footprint,investigate,passive}] [-T] [-o {tab,csv,json}] [-H] [-n] [-r] [-S LENGTH] [-D DELIMITER] [-f] [-F type1,type2,...] [-x] [-q] [-V] [-max-threads MAX_THREADS]',
                    "examples" => array(
                        array(
                            "title" => "",
                            "describe" => '以调试模式启动spiderfoot软件对应的web环境（在启动时指定本地监听IP与监听端口）（当提示 Correlation rules directory does not exist: /usr/share/spiderfoot/correlations/ 时，可使用适当账户及权限执行目录创建命令 mkdir -p /usr/share/spiderfoot/correlations/ ,之后重新尝试启动 spiderfoot ）',
                            "command" => "spiderfoot -l <本地IP地址>:<本地监听端口> --debug",
                        ),
                    ),
                ),
            ),
        );
        if (!is_cli()) {
            $_form_top = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Information Gathering Commands</div>';
            $_form = array(
                "action" => "/guide/penetration_test_commands",
                "inputs" => array(),
                "textareas" => array(),
                "submit" => array(
                    "value" => " return to Penetration Test Commands ",
                    "display" => true,
                ),
                "reset" => array(
                    "display" => false,
                ),
            );
            self::_commands_format_to_form_textareas($_common_commands, $_form);
            $_top = Class_View_Top::top();
            $_body = array(
                "menu" => Class_View_Guide_PenetrationTestCommands_Menu::menu(),
                "content" => (($_form_top) . Class_View::form_body($_form)),
            );
            $_bottom = Class_View_Bottom::bottom();
            Class_Base_Response::output(Class_View::index($_top, $_body, $_bottom), "text", 0);
        }
        return null;
    }

    public static function vulnerability_analysis($params = array())
    {
        if ((!is_cli()) && (!Class_Base_Auth::is_login())) {
            Class_Base_Response::redirect("/login");
            return null;
        }
        $_common_commands = array(
            "vulnerability_analysis" => array(
                "openvas" => array(
                    "title" => 'openvas : ',
                    "describe" => '开放式漏洞评估系统（Web界面）（默认监听 tcp 9390 端口）',
                    "command" => 'openvas',
                    "examples" => array(),
                ),
                "nessus" => array(
                    "title" => 'nessus : ',
                    "describe" => '系统漏洞扫描与分析软件（Web界面）（默认监听 tcp 8834 端口）',
                    "command" => 'nessus',
                    "examples" => array(),
                ),
                "nikto" => array(
                    "title" => 'nikto : ',
                    "describe" => '开源WEB安全扫描器（

   Options:
   
       -ask+               Whether to ask about submitting updates
                               yes   Ask about each (default)
                               no    Don\'t ask, don\'t send
                               auto  Don\'t ask, just send
       -check6             Check if IPv6 is working (connects to ipv6.google.com or value set in nikto.conf)
       -Cgidirs+           Scan these CGI dirs: "none", "all", or values like "/cgi/ /cgi-a/"
       -config+            Use this config file
       -Display+           Turn on/off display outputs:
                               1     Show redirects
                               2     Show cookies received
                               3     Show all 200/OK responses
                               4     Show URLs which require authentication
                               D     Debug output
                               E     Display all HTTP errors
                               P     Print progress to STDOUT
                               S     Scrub output of IPs and hostnames
                               V     Verbose output
       -dbcheck           Check database and other key files for syntax errors
       -evasion+          Encoding technique:
                               1     Random URI encoding (non-UTF8)
                               2     Directory self-reference (/./)
                               3     Premature URL ending
                               4     Prepend long random string
                               5     Fake parameter
                               6     TAB as request spacer
                               7     Change the case of the URL
                               8     Use Windows directory separator (\)
                               A     Use a carriage return (0x0d) as a request spacer
                               B     Use binary value 0x0b as a request spacer
        -followredirects   Follow 3xx redirects to new location
        -Format+           Save file (-o) format:
                               csv   Comma-separated-value
                               json  JSON Format
                               htm   HTML Format
                               nbe   Nessus NBE format
                               sql   Generic SQL (see docs for schema)
                               txt   Plain text
                               xml   XML Format
                               (if not specified the format will be taken from the file extension passed to -output)
       -Help              This help information
       -host+             Target host/URL
       -id+               Host authentication to use, format is id:pass or id:pass:realm
       -ipv4                 IPv4 Only
       -ipv6                 IPv6 Only
       -key+              Client certificate key file
       -list-plugins      List all available plugins, perform no testing
       -maxtime+          Maximum testing time per host (e.g., 1h, 60m, 3600s)
       -mutate+           Guess additional file names:
                               1     Test all files with all root directories
                               2     Guess for password file names
                               3     Enumerate user names via Apache (/~user type requests)
                               4     Enumerate user names via cgiwrap (/cgi-bin/cgiwrap/~user type requests)
                               5     Attempt to brute force sub-domain names, assume that the host name is the parent domain
                               6     Attempt to guess directory names from the supplied dictionary file
       -mutate-options    Provide information for mutates
       -nointeractive     Disables interactive features
       -nolookup          Disables DNS lookups
       -nossl             Disables the use of SSL
       -noslash           Strip trailing slash from URL (e.g., \'/admin/\' to \'/admin\')
       -no404             Disables nikto attempting to guess a 404 page
       -Option            Over-ride an option in nikto.conf, can be issued multiple times
       -output+           Write output to this file (\'.\' for auto-name)
       -Pause+            Pause between tests (seconds)
       -Plugins+          List of plugins to run (default: ALL)
       -port+             Port to use (default 80)
       -RSAcert+          Client certificate file
       -root+             Prepend root value to all requests, format is /directory
       -Save              Save positive responses to this directory (\'.\' for auto-name)
       -ssl               Force ssl mode on port
       -Tuning+           Scan tuning:
                               1     Interesting File / Seen in logs
                               2     Misconfiguration / Default File
                               3     Information Disclosure
                               4     Injection (XSS/Script/HTML)
                               5     Remote File Retrieval - Inside Web Root
                               6     Denial of Service
                               7     Remote File Retrieval - Server Wide
                               8     Command Execution / Remote Shell
                               9     SQL Injection
                               0     File Upload
                               a     Authentication Bypass
                               b     Software Identification
                               c     Remote Source Inclusion
                               d     WebService
                               e     Administrative Console
                               x     Reverse Tuning Options (i.e., include all except specified)
       -timeout+          Timeout for requests (default 10 seconds)
       -Userdbs           Load only user databases, not the standard databases
                               all   Disable standard dbs and load only user dbs
                               tests Disable only db_tests and load udb_tests
       -useragent         Over-rides the default useragent
       -until             Run until the specified time or duration
       -url+              Target host/URL (alias of -host)
       -usecookies        Use cookies from responses in future requests
       -useproxy          Use the proxy defined in nikto.conf, or argument http://server:port
       -Version           Print plugin and database versions
       -vhost+            Virtual host (for Host header)
       -404code           Ignore these HTTP codes as negative responses (always). Format is "302,301".
       -404string         Ignore this string in response body content as negative response (always). Can be a regular expression.
   		+ requires a value

                    ）
                    ',
                    "command" => 'nikto -h <目标URL>',
                    "examples" => array(
                        array(
                            "title" => "",
                            "describe" => "对指定URL进行HTTP扫描（访问指定端口）",
                            "command" => "nikto -h <目标URL> -p 80",
                        ),
                        array(
                            "title" => "",
                            "describe" => "对指定URL进行HTTPS扫描（访问指定端口）",
                            "command" => "nikto -h <目标URL> -p 443 -ssl",
                        ),
                        array(
                            "title" => "",
                            "describe" => "对指定URL进行HTTPS扫描（访问指定端口）",
                            "command" => "nikto -h <目标站点域名> -p 443 -ssl",
                        ),
                        array(
                            "title" => "",
                            "describe" => "对目标站点的进行目录爆破（使用HTTPS协议）",
                            "command" => "nikto -h <目标站点域名> -p 443 -ssl -c all",
                        ),
                    ),
                ),
                "unix-privesc-check" => array(
                    "title" => 'unix-privesc-check : ',
                    "describe" => '提权漏洞快速检测工具（
                    
unix权限检查v1.4（http://pentestmonkey.net/tools/unix-privesc-check）


用法：unix-privaesc-check｛standard|detailed｝


“标准”模式：对大量安全设置进行速度优化检查。


“详细”模式：与标准模式相同，但也检查打开文件的排列句柄和调用的文件（例如，从shell脚本解析，链接.so文件）。此模式速度慢且容易出错积极的一面，但可能会帮助你在第三名中发现更微妙的缺陷派对节目。此脚本检查文件权限和其他可能允许本地用户升级权限。


只有在您获得授权的系统上才允许使用此脚本对进行安全评估的合法许可。除此之外条件GPL v2适用。

在输出中搜索单词“WARNING”。如果你没有看到，那么这个脚本并没有发现任何问题。
                    
                    ）',
                    "command" => 'unix-privesc-check',
                    "examples" => array(
                        array(
                            "title" => "",
                            "describe" => "以标准模式进行本地扫描",
                            "command" => "unix-privesc-check standard",
                        ),
                        array(
                            "title" => "",
                            "describe" => "以详细模式进行本地扫描",
                            "command" => "unix-privesc-check detailed",
                        ),
                    ),
                ),
            ),
        );
        Class_Base_Auth::check_permission();
        if (!is_cli()) {
            $_form_top = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Vulnerability Analysis Commands</div>';
            $_form = array(
                "action" => "/guide/penetration_test_commands",
                "inputs" => array(),
                "textareas" => array(),
                "submit" => array(
                    "value" => " return to Penetration Test Commands ",
                    "display" => true,
                ),
                "reset" => array(
                    "display" => false,
                ),
            );
            self::_commands_format_to_form_textareas($_common_commands, $_form);
            $_top = Class_View_Top::top();
            $_body = array(
                "menu" => Class_View_Guide_PenetrationTestCommands_Menu::menu(),
                "content" => (($_form_top) . Class_View::form_body($_form)),
            );
            $_bottom = Class_View_Bottom::bottom();
            Class_Base_Response::output(Class_View::index($_top, $_body, $_bottom), "text", 0);
        }
        return null;
    }

    public static function web_program($params = array())
    {
        if ((!is_cli()) && (!Class_Base_Auth::is_login())) {
            Class_Base_Response::redirect("/login");
            return null;
        }
        $_common_commands = array(
            "web_program" => array(
                "dirb" => array(
                    "title" => 'dirb : ',
                    "describe" => 'web网站目录猜解工具（参数选项：
                    
 -a <agent_string>  : 指定自定义的USER_AGENT信息；
 
 -b                 : 按原样使用路径；
 
 -c <cookie_string> : 为HTTP请求设置一个cookie；
 
 -E <certificate>   : 指定客户端证书的路径；
 
 -f                 : 对于 NOT_FOUND（404）状态检测的微调；
 
 -H <header_string> : 向HTTP请求添加自定义标头；
 
 -i                 : 使用不区分大小写的搜索；
 
 -l                 : 找到时打印“Location（位置）”标题；
 
 -N <nf_code>       : 忽略使用此HTTP代码的响应；
 
 -o <output_file>   : 将输出保存到磁盘；
 
 -p <proxy[:port]>  : 使用此代理。（默认端口为1080）；
 
 -P <proxy_username:proxy_password> : 代理身份验证；
 
 -r                     : 不要进行递归搜索；
 
 -R                     : 交互式递归。（询问每个目录）；
 
 -S                     : 静音模式。不要显示测试过的单词。（对于哑端子）；
 
 -t                     : 不要在URL上强制使用\'/\'结尾；
 
 -u <username:password> : HTTP身份验证；
 
 -v                     : 还显示NOT_FOUND页面；
 
 -w                     : 不要停留在警告信息上；
 
 -X <extensions> / -x <exts_file> : 用这个扩展名附加每个单词；
 
 -z <millisecs> : 添加一个毫秒延迟以避免引发过大的洪水；
  
                    
                    ）',
                    "command" => 'dirb <url_base> [<wordlist_file(s)>] [options]',
                    "style" => 'height:250px;',
                    "examples" => array(
                        array(
                            "title" => "",
                            "describe" => "转到下一个目录",
                            "command" => "n",
                        ),
                        array(
                            "title" => "",
                            "describe" => "停止扫描（保存当前状态，以备进行后续查询）",
                            "command" => "q",
                        ),
                        array(
                            "title" => "",
                            "describe" => "剩余扫描统计数据",
                            "command" => "r",
                        ),
                    ),
                ),
                "burpsuite" => array(
                    "title" => 'burpsuite : ',
                    "describe" => '开放式漏洞评估系统（Web界面）',
                    "command" => 'burpsuite',
                    "examples" => array(),
                ),
                "commix" => array(
                    "title" => 'commix : ',
                    "describe" => '开源自动化检测系统命令注入工具（
                    
Options: 
  -h, --help            Show help and exit. （显示帮助信息）

  General: （常规）
    These options relate to general matters. （这些选择涉及一般事项）

    -v VERBOSE          Verbosity level (0-4, Default: 0). （VERBOSE详细程度级别（0-1，默认值：0）。）
    
    --version           Show version number and exit. （显示版本号）
    
    --output-dir=OUT..  Set custom output directory path. （自定义输出目录）
    
    -s SESSION_FILE     Load session from a stored (.sqlite) file. （从一个存储文件（ 扩展名 .sqlite ）中导入会话）
    
    --flush-session     Flush session files for current target.  （刷新当前目标的会话文件）
    
    --ignore-session    Ignore results stored in session file. （忽略存储在会话文件中的结果）
    
    -t TRAFFIC_FILE     Log all HTTP traffic into a textual file. （将所有HTTP流量记录到文本文件中）
    
    --batch             Never ask for user input, use the default behaviour. （从不要求用户输入，使用默认行为）
    
    --skip-heuristics   Skip heuristic detection for code injection. （代码注入的跳过启发式检测）
    
    --codec=CODEC       Force codec for character encoding (e.g. \'ascii\'). （强制编解码器进行字符编码（例如“ascii”））
    
    --charset=CHARSET   Time-related injection charset (e.g."0123456789abcdef") （与时间相关的注入字符集（例如“0123456789abdedf”））
    
    --check-internet    Check internet connection before assessing the target. （在评估目标之前检查互联网连接）

  Target: （目标）
    This options has to be provided, to define the target URL. （必须提供此选项，才能定义目标URL）

    -u URL, --url=URL   Target URL. （目标URL）
    
    --url-reload        Reload target URL after command execution. （命令执行后重新加载目标URL）
    
    -l LOGFILE          Parse target from HTTP proxy log file. （从HTTP代理日志文件分析目标）
    
    -m BULKFILE         Scan multiple targets given in a textual file. （扫描文本文件中给定的多个目标）
    
    -r REQUESTFILE      Load HTTP request from a file. （从文件加载HTTP请求）
    
    --crawl=CRAWLDEPTH  Crawl the website starting from the target URL (1-2,Default: 0). （从目标URL开始爬网网站（1-2，默认值：0））
    
    -x SITEMAP_URL      Parse target(s) from remote sitemap(.xml) file. （从远程站点地图（.xml）文件分析目标）
    
    --method=METHOD     Force usage of given HTTP method (e.g. PUT) （强制使用给定的HTTP方法（例如PUT））

  Request: （请求）
    These options can be used to specify how to connect to the target URL. （这些选项可用于指定如何连接到目标URL）

    -d DATA, --data=..  Data string to be sent through POST. （要通过POST发送的数据字符串）
    
    --host=HOST         HTTP Host header. （HTTP主机标头）
    
    --referer=REFERER   HTTP Referer header. （HTTP Referer标头）
    
    --user-agent=AGENT  HTTP User-Agent header. （HTTP用户代理标头）
    
    --random-agent      Use a randomly selected HTTP User-Agent header. （使用随机选择的HTTP用户代理标头）
    
    --param-del=PDEL    Set character for splitting parameter values. （设置用于拆分参数值的字符）
    
    --cookie=COOKIE     HTTP Cookie header. （HTTP Cookie标头）
    
    --cookie-del=CDEL   Set character for splitting cookie values. （设置用于拆分cookie值的字符） 
    
    -H HEADER, --hea..  Extra header (e.g. \'X-Forwarded-For: 127.0.0.1\'). （额外标头（例如“X-Forwarded-For:120.0.1\'”））
    
    --headers=HEADERS   Extra headers (e.g. \'Accept-Language: fr\nETag: 123\'). （额外的标题（例如“Accept Language：fr\nTag：123”））
    
    --proxy=PROXY       Use a proxy to connect to the target URL. （使用代理连接到目标URL）
    
    --tor               Use the Tor network. （使用Tor网络）
    
    --tor-port=TOR_P..  Set Tor proxy port (Default: 8118). （设置Tor代理端口（默认值：8118））
    
    --tor-check         Check to see if Tor is used properly. （检查Tor是否正确使用）
    
    --auth-url=AUTH_..  Login panel URL. （登录面板URL）
    
    --auth-data=AUTH..  Login parameters and data. （登录参数和数据）
    
    --auth-type=AUTH..  HTTP authentication type (e.g. \'Basic\' or \'Digest\'). （HTTP身份验证类型（例如“基本”或“摘要”） ）
    
    --auth-cred=AUTH..  HTTP authentication credentials (e.g. \'admin:admin\'). （HTTP身份验证凭据（例如“admin:admin”） ）
    
    --ignore-code=IG..  Ignore (problematic) HTTP error code (e.g. 401). （忽略（有问题的）HTTP错误代码（例如401） ）
    
    --force-ssl         Force usage of SSL/HTTPS. （强制使用SSL/HTTPS）
    
    --ignore-redirects  Ignore redirection attempts. （忽略重定向尝试）
    
    --timeout=TIMEOUT   Seconds to wait before timeout connection (default 30). （连接超时前等待的秒数（默认值为30））
    
    --retries=RETRIES   Retries when the connection timeouts (Default: 3). （连接超时时重试（默认值：3））
    
    --drop-set-cookie   Ignore Set-Cookie header from response. （忽略响应中的Set Cookie标头）

  Enumeration: （枚举）
    These options can be used to enumerate the target host. （这些选项可用于枚举目标主机）

    --all               Retrieve everything. （检索所有内容）
    
    --current-user      Retrieve current user name. （检索当前用户名）
    
    --hostname          Retrieve current hostname. （检索当前主机名）
    
    --is-root           Check if the current user have root privileges. （检查当前用户是否具有root权限）
    
    --is-admin          Check if the current user have admin privileges. （检查当前用户是否具有管理员权限）
    
    --sys-info          Retrieve system information. （检索系统信息）
    
    --users             Retrieve system users. （检索系统用户）
    
    --passwords         Retrieve system users password hashes. （检索系统用户密码哈希）
    
    --privileges        Retrieve system users privileges. （检索系统用户权限）
    
    --ps-version        Retrieve PowerShell\'s version number. （检索PowerShell的版本号）

  File access: （文件访问）
    These options can be used to access files on the target host. （这些选项可用于访问目标主机上的文件）

    --file-read=FILE..  Read a file from the target host. （从目标主机中读取一个文件）
    
    --file-write=FIL..  Write to a file on the target host. （向目标主机写入一个文件）
    
    --file-upload=FI..  Upload a file on the target host. （上传一个文件到目标主机）
    
    --file-dest=FILE..  Host\'s absolute filepath to write and/or upload to. （要写入和/或上载到的主机的绝对文件路径）

  Modules: （模块）
    These options can be used increase the detection and/or injection capabilities. （可以使用这些选项来提高检测和/或注入能力）

    --icmp-exfil=IP_..  The \'ICMP exfiltration\' injection module. (e.g. \'ip_src=192.168.178.1,ip_dst=192.168.178.3\').  （“ICMP exfiltering”注入模块）（例如“ip_src=192.168.178.1，ip_dst=192.168.178.3” ）
                        
    --dns-server=DNS..  The \'DNS exfiltration\' injection module.(Domain name used for DNS exfiltration attack). （“DNS exfiltering”注入模块。（用于DNS exfiltering攻击的域名）。）
    
    --shellshock        The \'shellshock\' injection module. （“shell shock”注入模块）

  Injection: （注射）
    These options can be used to specify which parameters to inject and to provide custom injection payloads. （这些选项可用于指定要注入的参数以及提供自定义注入有效载荷）

    -p TEST_PARAMETER   Testable parameter(s). （可测试参数）
    
    --skip=SKIP_PARA..  Skip testing for given parameter(s). （跳过给定参数的测试）
    
    --suffix=SUFFIX     Injection payload suffix string. （注入有效载荷后缀字符串）
    
    --prefix=PREFIX     Injection payload prefix string. （注入有效负载前缀字符串）
    
    --technique=TECH    Specify injection technique(s) to use.  （指定要使用的注射技术）
    
    --skip-technique..  Specify injection technique(s) to skip. （指定要跳过的注入技术）
    
    --maxlen=MAXLEN     Set the max length of output for time-related injection techniques (Default: 10000 chars). （设置与时间相关的注入技术的最大输出长度（默认值：10000个字符））
    
    --delay=DELAY       Seconds to delay between each HTTP request.（每个HTTP请求之间的延迟秒数，建议设置为每次探测延时1秒（防止访问过快而导致目标系统崩溃））
    
    --time-sec=TIMESEC  Seconds to delay the OS response (Default 1). （延迟操作系统响应的秒数（默认值1））
    
    --tmp-path=TMP_P..  Set the absolute path of web server\'s temp directory. （设置web服务器临时目录的绝对路径）
    
    --web-root=WEB_R..  Set the web server document root directory (e.g.\'/var/www\'). （设置web服务器文档根目录（例如“/var/www”））
    
    --alter-shell=AL..  Use an alternative os-shell (e.g. \'Python\'). （使用其他操作系统外壳（例如“Python”））
    
    --os-cmd=OS_CMD     Execute a single operating system command. （执行单个操作系统命令）
    
    --os=OS             Force back-end operating system (e.g. \'Windows\' or\'Unix\'). （强制后端操作系统（例如“Windows”或“Unix”）。）
    
    --tamper=TAMPER     Use given script(s) for tampering injection data. （使用给定的脚本来篡改注入数据。）
    
    --msf-path=MSF_P..  Set a local path where metasploit is installed. （设置安装metasploit的本地路径）

  Detection: （检测）
    These options can be used to customize the detection phase. （这些选项可用于自定义检测阶段）

    --level=LEVEL       Level of tests to perform (1-3, Default: 1).（要执行的测试级别（1-3，默认值：1））
    
    --skip-calc         Skip the mathematic calculation during the detection phase. （在检测阶段跳过数学计算）
    
    --skip-empty        Skip testing the parameter(s) with empty value(s). （跳过测试具有空值的参数）
    
    --failed-tries=F..  Set a number of failed injection tries, in file-based technique. （以基于文件的技术设置失败的注入尝试次数。）

  Miscellaneous: （混杂）
  
    --dependencies      Check for third-party (non-core) dependencies. （检查第三方（非核心）依赖关系）
    
    --list-tampers      Display list of available tamper scripts （显示可用篡改脚本的列表）
    
    --purge             Safely remove all content from commix data directory. （安全地从commix数据目录中删除所有内容）
    
    --skip-waf          Skip heuristic detection of WAF/IPS/IDS protection. （WAF/IPS/IDS保护的跳过启发式检测）
    
    --mobile            Imitate smartphone through HTTP User-Agent header. （通过HTTP用户代理标头模拟智能手机）
    
    --offline           Work in offline mode. （在脱机模式下工作）
    
    --wizard            Simple wizard interface for beginner users. （适用于初学者的简单向导界面）
    
    --disable-coloring  Disable console output coloring. （禁用控制台输出着色）

                    
                    ）',
                    "command" => 'commix [option(s)]',
                    "style" => 'height:400px;',
                    "examples" => array(
                        array(
                            "title" => "",
                            "describe" => "commix注入",
                            "command" => "commix --url \"<目标URL>\" --cookie=\"<目标COOKIE>\" --data=\"<POST格式字符串>\"",
                        ),
                    ),
                ),
                "skipfish" => array(
                    "title" => 'skipfish : ',
                    "describe" => '高度自动化的Web应用程序安全测试工具（
                    
Authentication and access options: （身份验证和访问选项）

  -A user:pass      - use specified HTTP authentication credentials （使用指定的HTTP认证凭证）
  
  -F host=IP        - pretend that \'host\' resolves to \'IP\' （假设\'host\'解析为\'IP\'）
  
  -C name=val       - append a custom cookie to all requests （向所有请求附加一个自定义cookie）
  
  -H name=val       - append a custom HTTP header to all requests （向所有请求附加一个自定义HTTP头）
  
  -b (i|f|p)        - use headers consistent with MSIE / Firefox / iPhone （使用与MSIE / Firefox / iPhone一致的头文件）
  
  -N                - do not accept any new cookies （不接受任何新的cookie）
  
  --auth-form url   - form authentication URL （表单认证url）
  
  --auth-user user  - form authentication user （form认证用户）
  
  --auth-pass pass  - form authentication password （form认证密码）
  
  --auth-verify-url -  URL for in-session detection （会话内检测的URL）
  

Crawl scope options: （爬网范围选项）

  -d max_depth     - maximum crawl tree depth (16) （爬行树的最大深度(16)）
  
  -c max_child     - maximum children to index per node (512) （每个节点索引的最大子节点数(512)）
  
  -x max_desc      - maximum descendants to index per branch (8192) （每个分支索引的最大子代数 (8192)）
  
  -r r_limit       - max total number of requests to send (100000000) （发送的最大请求总数 (100000000)）
  
  -p crawl%        - node and link crawl probability (100%) （节点和链路抓取概率 (100%)）
  
  -q hex           - repeat probabilistic scan with given seed （重复概率扫描与给定种子）
  
  -I string        - only follow URLs matching \'string\' （只跟踪匹配\'string\'的url）
  
  -X string        - exclude URLs matching \'string\' （排除匹配\'string\'的url）
  
  -K string        - do not fuzz parameters named \'string\' （不模糊名为string的参数）
  
  -D domain        - crawl cross-site links to another domain （抓取跨站点链接到另一个域）
  
  -B domain        - trust, but do not crawl, another domain （信任，但不抓取，另一个域）
  
  -Z               - do not descend into 5xx locations （不要下降到5xx位置）
  
  -O               - do not submit any forms （不提交任何表格）
  
  -P               - do not parse HTML, etc, to find new links （不解析HTML等来查找新链接）
  

Reporting options: （报告选项）

  -o dir          - write output to specified directory (required) （将输出写入指定目录(必需)）
  
  -M              - log warnings about mixed content / non-SSL passwords （关于混合内容/非ssl密码的日志警告）
  
  -E              - log all HTTP/1.0 / HTTP/1.1 caching intent mismatches （log 所有HTTP/1.0 / HTTP/1.1缓存意图不匹配的日志）
  
  -U              - log all external URLs and e-mails seen （log 记录所有外部网址和电子邮件）
  
  -Q              - completely suppress duplicate nodes in reports （完全抑制报告中重复的节点）
  
  -u              - be quiet, disable realtime progress stats （安静，禁用实时进度统计）
  
  -v              - enable runtime logging (to stderr) （启用运行时日志记录(stderr)）
  

Dictionary management options: （字典管理选项）

  -W wordlist     - use a specified read-write wordlist (required) （使用指定的读写单词列表(必需)）
  
  -S wordlist     - load a supplemental read-only wordlist （加载一个补充的只读wordlist）
  
  -L              - do not auto-learn new keywords for the site （不自动学习网站的新关键词）
  
  -Y              - do not fuzz extensions in directory brute-force （不要模糊目录中的扩展名）
  
  -R age          - purge words hit more than \'age\' scans ago （清除词比扫描前的“age”更多）
  
  -T name=val     - add new form auto-fill rule （添加新表单自动填充规则）
  
  -G max_guess    - maximum number of keyword guesses to keep (256) （最大的关键字猜测数量(256)）

  -z sigfile      - load signatures from this file （从这个文件加载签名）
  

Performance settings: （性能设置）

  -g max_conn     - max simultaneous TCP connections, global (40) （最大TCP并发连接数，全局(40)）
  
  -m host_conn    - max simultaneous connections, per target IP (10) （每个目标IP最大并发连接数(10)）
  
  -f max_fail     - max number of consecutive HTTP errors (100) （最大连续HTTP错误数(100)）
  
  -t req_tmout    - total request response timeout (20 s) （总请求响应超时时间(20秒)）
  
  -w rw_tmout     - individual network I/O timeout (10 s) （个人网络I/O超时(10秒)）
  
  -i idle_tmout   - timeout on idle HTTP connections (10 s) （空闲时超时 HTTP连接(10秒)）
  
  -s s_limit      - response size limit (400000 B) （响应大小限制(400000 B)）
  
  -e              - do not keep binary responses for reporting （不保留二进制响应报告）
  

Other settings:（其它设置）

  -l max_req      - max requests per second (0.000000) （每秒最大请求数(0.000000)）
  
  -k duration     - stop scanning after the given duration h:m:s （在给定的持续时间h:m:s后停止扫描）
  
  --config file   - load the specified configuration file （加载指定的配置文件）


Send comments and complaints to <heinenn@google.com>. （将评论和投诉发送到<heinenn@google.com>。）
                    
                    ）',
                    "command" => 'skipfish [ options ... ] -W wordlist -o output_dir start_url [ start_url2 ... ]',
                    "examples" => array(
                        array(
                            "title" => "",
                            "describe" => "对指定URL进行安全扫描（-o 将输出结果写入到指定目录，-I 只跟踪匹配'string'的url）",
                            "command" => "skipfish -o <指定输出目录> -I <指定字符串> <指定URL>",
                        ),
                    ),
                ),
                "wpscan" => array(
                    "title" => 'wpscan : ',
                    "describe" => '基于白盒测试的WordPress安全扫描器（
                    
options: 

    --url URL : The URL of the blog to scan
              : Allowed Protocols: http, https
              : Default Protocol if none provided: http
              : This option is mandatory unless update or help or hh or version is/are supplied

-h, --help : Display the simple help and exit

    --hh : Display the full help and exit

    --version : Display the version and exit

-v, --verbose : Verbose mode （显示详细的扫描信息，共有5个等级，指定sqlmap使用何种类型的SQL注入方法）

    --[no-]banner : Whether or not to display the banner ( Default: true )
    
-o, --output FILE : Output to FILE

-f, --format FORMAT : Output results in the format supplied
                    : Available choices: cli-no-colour, cli-no-color, cli, json

    --detection-mode MODE : Available choices: mixed, passive, aggressive ( Default: mixed )
                                                  
    --user-agent, --ua VALUE

    --random-user-agent, --rua : Use a random user-agent for each scan

    --http-auth login:password

-t, --max-threads VALUE : The max threads to use ( Default: 5 )

    --throttle MilliSeconds : Milliseconds to wait before doing another web request. If used, the max threads will be set to 1.

    --request-timeout SECONDS : The request timeout in seconds ( Default: 60 )
    
    --connect-timeout SECONDS : The connection timeout in seconds ( Default: 30 )
    
    --disable-tls-checks : Disables SSL/TLS certificate verification, and downgrade to TLS1.0+ (requires cURL 7.66 for the latter)

    --proxy protocol://IP:port : Supported protocols depend on the cURL installed （中文注释：通过代理方式使用SQLMAP工具）

    --proxy-auth login:password

    --cookie-string COOKIE : Cookie string to use in requests, format: cookie1=value1[; cookie2=value2]

    --cookie-jar FILE-PATH : File to read and write cookies ( Default: /tmp/wpscan/cookie_jar.txt )
    
    --force : Do not check if the target is running WordPress or returns a 403

    --[no-]update : Whether or not to update the Database

    --api-token TOKEN : The WPScan API Token to display vulnerability data, available at https://wpscan.com/profile

    --wp-content-dir DIR : The wp-content directory if custom or not detected, such as "wp-content"

    --wp-plugins-dir DIR : The plugins directory if custom or not detected, such as "wp-content/plugins"

    -e, --enumerate [OPTS] : Enumeration Process
                           : Available Choices:
                             : vp   Vulnerable plugins
                             : ap   All plugins
                             : p    Popular plugins
                             : vt   Vulnerable themes
                             : at   All themes
                             : t    Popular themes
                             : tt   Timthumbs
                             : cb   Config backups
                             : dbe  Db exports
                             : u    User IDs range. e.g: u1-5
                                    Range separator to use: \'-\'
                                    Value if no argument supplied: 1-10
                             : m    Media IDs range. e.g m1-15
                             : Note: Permalink setting must be set to "Plain" for those to be detected
                                     Range separator to use: \'-\'
                                     Value if no argument supplied: 1-100
                                     Separator to use between the values: \',\'
                                     Default: All Plugins, Config Backups
                                     Value if no argument supplied: vp,vt,tt,cb,dbe,u,m
                                     Incompatible choices (only one of each group/s can be used):
                                     - vp, ap, p
                                     - vt, at, t

    --exclude-content-based REGEXP_OR_STRING : Exclude all responses matching the Regexp (case insensitive) during parts of the enumeration.
                                               Both the headers and body are checked. Regexp delimiters are not required.

    --plugins-detection MODE : Use the supplied mode to enumerate Plugins. ( Default: passive )
                               Available choices: mixed, passive, aggressive
                               
    --plugins-version-detection MODE : Use the supplied mode to check plugins\' versions. ( Default: mixed )
                                       Available choices: mixed, passive, aggressive
                                                  
    --exclude-usernames REGEXP_OR_STRING : Exclude usernames matching the Regexp/string (case insensitive). Regexp delimiters are not required.

-P, --passwords FILE-PATH : List of passwords to use during the password attack.
                            If no --username/s option supplied, user enumeration will be run.
                            
-U, --usernames LIST : List of usernames to use during the password attack.
                       Examples: \'a1\', \'a1,a2,a3\', \'/tmp/a.txt\'
                       
    --multicall-max-passwords MAX_PWD : Maximum number of passwords to send by request with XMLRPC multicall ( Default: 500 )
    
    --password-attack ATTACK : Force the supplied attack to be used rather than automatically determining one.
                               Available choices: wp-login, xmlrpc, xmlrpc-multicall
                               
    --login-uri URI : The URI of the login page if different from /wp-login.php

    --stealthy : Alias for --random-user-agent --detection-mode passive --plugins-version-detection passive

[!] To see full list of options use --hh.

        
                    ）',
                    "command" => 'wpscan [options]',
                    "style" => 'height:300px;line-height:24px;',
                    "examples" => array(
                        array(
                            "title" => "",
                            "describe" => "常规扫描",
                            "command" => "wpscan --url \"<目标URL>\"",
                        ),
                        array(
                            "title" => "",
                            "describe" => "主题扫描",
                            "command" => "wpscan --url \"<目标URL>\" --enumerate t",
                        ),
                        array(
                            "title" => "",
                            "describe" => "主题漏洞扫描",
                            "command" => "wpscan --url \"<目标URL>\" --enumerate vt",
                        ),
                        array(
                            "title" => "",
                            "describe" => "插件扫描",
                            "command" => "wpscan --url \"<目标URL>\" --enumerate p",
                        ),
                        array(
                            "title" => "",
                            "describe" => "插件漏洞扫描",
                            "command" => "wpscan --url \"<目标URL>\" --enumerate vp",
                        ),
                        array(
                            "title" => "",
                            "describe" => "枚举wordpress用户",
                            "command" => "wpscan --url \"<目标URL>\" --enumerate u",
                        ),
                        array(
                            "title" => "",
                            "describe" => "用户名密码暴力破解",
                            "command" => "wpscan --url \"<目标URL>\" --username <用户名> --wordlist <密码字典文件>",
                        ),
                    ),
                ),
            ),
        );
        Class_Base_Auth::check_permission();
        if (!is_cli()) {
            $_form_top = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Web Program Commands</div>';
            $_form = array(
                "action" => "/guide/penetration_test_commands",
                "inputs" => array(),
                "textareas" => array(),
                "submit" => array(
                    "value" => " return to Penetration Test Commands ",
                    "display" => true,
                ),
                "reset" => array(
                    "display" => false,
                ),
            );
            self::_commands_format_to_form_textareas($_common_commands, $_form);
            $_top = Class_View_Top::top();
            $_body = array(
                "menu" => Class_View_Guide_PenetrationTestCommands_Menu::menu(),
                "content" => (($_form_top) . Class_View::form_body($_form)),
            );
            $_bottom = Class_View_Bottom::bottom();
            Class_Base_Response::output(Class_View::index($_top, $_body, $_bottom), "text", 0);
        }
        return null;
    }

    public static function database_evaluation($params = array())
    {
        if ((!is_cli()) && (!Class_Base_Auth::is_login())) {
            Class_Base_Response::redirect("/login");
            return null;
        }
        $_common_commands = array(
            "database_evaluation" => array(
                "sqlmap" => array(
                    "title" => 'sqlmap : ',
                    "describe" => '自动化的SQL注入工具（
                    
Options:

  -h, --help            Show basic help message and exit
  
  -hh                   Show advanced help message and exit
  
  --version             Show program\'s version number and exit
  
  --is-dba              View database permissions for the current injection point （中文注释：查看当前注入点的数据库权限）
  
  -v VERBOSE            Verbosity level: 0-6 (default 1)


Target:
    At least one of these options has to be provided to define the
    target(s)

    -u URL, --url=URL   Target URL (e.g. "http://www.site.com/vuln.php?id=1")
    
    -g GOOGLEDORK       Process Google dork results as target URLs


Request:
    These options can be used to specify how to connect to the target URL

    --data=DATA         Data string to be sent through POST (e.g. "id=1")
    
    --cookie=COOKIE     HTTP Cookie header value (e.g. "PHPSESSID=a8d127e..")
    
    --random-agent      Use randomly selected HTTP User-Agent header value （中文注释：随机请求头  默认情况下是sqlmap）
    
    --proxy=PROXY       Use a proxy to connect to the target URL
    
    --tor               Use Tor anonymity network
    
    --check-tor         Check to see if Tor is used properly


  Injection:
    These options can be used to specify which parameters to test for,
    provide custom injection payloads and optional tampering scripts

    -p TESTPARAMETER    Testable parameter(s)
    
    --dbms=DBMS         Force back-end DBMS to provided value
    

  Detection:
    These options can be used to customize the detection phase

    --level=LEVEL       Level of tests to perform (1-5, default 1)
    
    --risk=RISK         Risk of tests to perform (1-3, default 1) （中文注释：共有4个风险等级，默认值为1，风险等级越高，用来进行注入测试的SQL语句也就越多）（推荐的参数组合：（--level 3 --risk 2））


  Techniques:
    These options can be used to tweak testing of specific SQL injection
    techniques

    --technique=TECH..  SQL injection techniques to use (default "BEUSTQ") （中文注释：值可选范围：B: Boolean-based blind SQL injection（布尔型注入）、E: Error-based SQL injection（报错型注入）、U: UNION query SQL injection（可联合查询注入）、S: Stacked queries SQL injection（可多语句查询注入）、T: Time-based blind SQL injection（基于时间延迟注入）)


  Enumeration:
    These options can be used to enumerate the back-end database
    management system information, structure and data contained in the
    tables

    -a, --all           Retrieve everything
    
    -b, --banner        Retrieve DBMS banner
    
    --current-user      Retrieve DBMS current user
    
    --current-db        Retrieve DBMS current database
    
    --passwords         Enumerate DBMS users password hashes
    
    --dbs               Enumerate DBMS databases
    
    --tables            Enumerate DBMS database tables
    
    --columns           Enumerate DBMS database table columns
    
    --schema            Enumerate DBMS schema
    
    --dump              Dump DBMS database table entries
    
    --dump-all          Dump all DBMS databases tables entries
    
    -D DB               DBMS database to enumerate
    
    -T TBL              DBMS database table(s) to enumerate
    
    -C COL              DBMS database table column(s) to enumerate


  Operating system access:
    These options can be used to access the back-end database management
    system underlying operating system

    --os-shell          Prompt for an interactive operating system shell （直接获取目标的系统权限，仅在--is-dba选项的测试结果为true的时候可用）
    
    --os-pwn            Prompt for an OOB shell, Meterpreter or VNC


  General:
    These options can be used to set some general working parameters

    --batch             Never ask for user input, use the default behavior
    
    --flush-session     Flush session files for current target （中文注释：清除缓存，可以简写为 –z flu）


  Miscellaneous:
    These options do not fit into any other category

    --wizard            Simple wizard interface for beginner users

[!] to see full list of options run with \'-hh\'

                    
                    ）',
                    "command" => 'python3 sqlmap [options]',
                    "style" => 'height:300px;line-height:24px;',
                    "examples" => array(
                        array(
                            "title" => "",
                            "describe" => "探测目标是否存在GET方式的SQL注入漏洞",
                            "command" => "python3 sqlmap -u <目标URL>",
                        ),
                        array(
                            "title" => "",
                            "describe" => "探测目标是否存在POST方式的SQL注入漏洞（注意，每次SQL注入测试，均需使用保存有HTTP最新报文内容的指定文件）",
                            "command" => "python3 sqlmap -r <内容为HTTP请求报文的指定文件的绝对路径>",
                        ),
                        array(
                            "title" => "",
                            "describe" => "利用存在SQL注入漏洞的目标URL探测数据库服务器中的数据库名称列表",
                            "command" => "python3 sqlmap -u <目标URL> --dbs",
                        ),
                        array(
                            "title" => "",
                            "describe" => "利用存在SQL注入漏洞的目标URL探测数据库服务器中的当前数据库名称",
                            "command" => "python3 sqlmap -u <目标URL> --current-db",
                        ),
                        array(
                            "title" => "",
                            "describe" => "利用存在SQL注入漏洞的目标URL探测数据库服务器中的指定数据库对应的数据表名称列表",
                            "command" => "python3 sqlmap -u <目标URL> –D <数据库名称> --tables",
                        ),
                        array(
                            "title" => "",
                            "describe" => "利用存在SQL注入漏洞的目标URL探测数据库服务器中的指定数据库的指定数据表对应的数据字段名称列表",
                            "command" => "python3 sqlmap -u <目标URL> -D <数据库名称> –T <数据表名称> --columns",
                        ),
                        array(
                            "title" => "",
                            "describe" => "利用存在SQL注入漏洞的目标URL探测数据库服务器中的指定数据库的指定数据表对的指定数据字段对应的字段值列表",
                            "command" => "python3 sqlmap -u <目标URL> -D <数据库名称> –T <数据表名称> -C <数据字段名称> --dump",
                        ),
                        array(
                            "title" => "",
                            "describe" => "对登陆框（表单）进行SQL注入",
                            "command" => "python3 sqlmap -u <目标URL> --form",
                        ),
                    ),
                ),
                "sqlite-database-browser" => array(
                    "title" => 'sqlite-database-browser : ',
                    "describe" => 'Sqlite数据库可视化管理工具（图形化界面）',
                    "command" => 'sqlitebrowser',
                    "examples" => array(),
                ),
            ),
        );
        Class_Base_Auth::check_permission();
        if (!is_cli()) {
            $_form_top = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Database Evaluation Commands</div>';
            $_form = array(
                "action" => "/guide/penetration_test_commands",
                "inputs" => array(),
                "textareas" => array(),
                "submit" => array(
                    "value" => " return to Penetration Test Commands ",
                    "display" => true,
                ),
                "reset" => array(
                    "display" => false,
                ),
            );
            self::_commands_format_to_form_textareas($_common_commands, $_form);
            $_top = Class_View_Top::top();
            $_body = array(
                "menu" => Class_View_Guide_PenetrationTestCommands_Menu::menu(),
                "content" => (($_form_top) . Class_View::form_body($_form)),
            );
            $_bottom = Class_View_Bottom::bottom();
            Class_Base_Response::output(Class_View::index($_top, $_body, $_bottom), "text", 0);
        }
        return null;
    }

    public static function password_attack($params = array())
    {
        if ((!is_cli()) && (!Class_Base_Auth::is_login())) {
            Class_Base_Response::redirect("/login");
            return null;
        }
        $_common_commands = array(
            "password_attack" => array(
                "cewl" => array(
                    "title" => 'cewl : ',
                    "describe" => '利用网络爬虫技术来进行字典生成的工具软件（
                    
Options:

	-h, --help: Show help.
	
	-k, --keep: Keep the downloaded file.
	
	-d <x>,--depth <x>: Depth to spider to, default 2.
	
	-m, --min_word_length: Minimum word length, default 3.
	
	-x, --max_word_length: Maximum word length, default unset.
	
	-o, --offsite: Let the spider visit other sites.
	
	--exclude: A file containing a list of paths to exclude
	
	--allowed: A regex pattern that path must match to be followed
	
	-w, --write: Write the output to the file.
	
	-u, --ua <agent>: User agent to send.
	
	-n, --no-words: Don\'t output the wordlist.
	
	-g <x>, --groups <x>: Return groups of words as well
	
	--lowercase: Lowercase all parsed words
	
	--with-numbers: Accept words with numbers in as well as just letters
	
	--convert-umlauts: Convert common ISO-8859-1 (Latin-1) umlauts (ä-ae, ö-oe, ü-ue, ß-ss)
	
	-a, --meta: include meta data.
	
	--meta_file file: Output file for meta data.
	
	-e, --email: Include email addresses.
	
	--email_file <file>: Output file for email addresses.
	
	--meta-temp-dir <dir>: The temporary directory used by exiftool when parsing files, default /tmp.
	
	-c, --count: Show the count for each word found.
	
	-v, --verbose: Verbose.
	
	--debug: Extra debug information.


	Authentication
	
	--auth_type: Digest or basic.
	
	--auth_user: Authentication username.
	
	--auth_pass: Authentication password.


	Proxy Support
	
	--proxy_host: Proxy host.
	
	--proxy_port: Proxy port, default 8080.
	
	--proxy_username: Username for proxy, if required.
	
	--proxy_password: Password for proxy, if required.
	

	Headers
	
	--header, -H: In format name:value - can pass multiple.

    <url>: The site to spider.

                    
                    ）',
                    "command" => 'cewl [OPTIONS] ... <url>',
                    "examples" => array(
                        array(
                            "title" => "",
                            "describe" => "利用爬虫创建字典文件",
                            "command" => "cewl <目标URL> -w <字典文件保存路径>",
                        ),
                        array(
                            "title" => "",
                            "describe" => "利用爬虫创建字典文件（电子邮件地址列表）",
                            "command" => "cewl <目标URL> -n -e  -w <字典文件保存路径>",
                        ),
                    ),
                ),
                "crunch" => array(
                    "title" => 'crunch : ',
                    "describe" => '密码字典生成工具（
                    
Options:

       -b number[type]
              Specifies the size of the output file, only works if -o START is
              used,  i.e.:  60MB   The  output  files will be in the format of
              starting letter‐ending letter for example: ./crunch 4 5 -b 20mib
              -o START will generate 4 files: aaaa‐gvfed.txt, gvfee‐ombqy.txt,
              ombqz‐wcydt.txt, wcydu‐zzzzz.txt valid values for type  are  kb,
              mb,  gb,  kib, mib, and gib.  The first three types are based on
              1000 while the last three types are based on 1024.   NOTE  There
              is  no  space between the number and type.  For example 500mb is
              correct 500 mb is NOT correct.

       -c number
              Specifies the number of lines to  write  to  output  file,  only
              works if -o START is used, i.e.: 60  The output files will be in
              the   format  of  starting  letter‐ending  letter  for  example:
              ./crunch 1 1 -f  /pentest/password/crunch/charset.lst  mixalpha‐
              numeric‐all‐space -o START -c 60 will result in 2 files: a‐7.txt
              and  8‐\  .txt  The reason for the slash in  the second filename
              is the ending character is space and ls  has  to  escape  it  to
              print it.  Yes you will need to put in the \ when specifying the
              filename because the last character is a space.

       -d numbersymbol
              Limits  the  number  of  duplicate characters.  -d 2@ limits the
              lower case alphabet to output like aab and aac.  aaa  would  not
              be  generated as that is 3 consecutive letters of a.  The format
              is number then symbol where number is the maximum number of con‐
              secutive characters and symbol is the symbol of the the  charac‐
              ter set you want to limit i.e. @,%^   See examples 17‐19.

       -e string
              Specifies when crunch should stop early

       -f /path/to/charset.lst charset‐name
              Specifies a character set from the charset.lst

       -i  Inverts  the  output  so  instead  of  aaa,aab,aac,aad, etc you get
              aaa,baa,caa,daa,aba,bba, etc

       -l When you use the -t option this option tells  crunch  which  symbols
              should  be  treated as literals.  This will allow you to use the
              placeholders as letters in the pattern.  The -l option should be
              the same length as the -t option.  See example 15.

       -m Merged with -p.  Please use -p instead.

       -o wordlist.txt
              Specifies the file to write the output to, eg: wordlist.txt

       -p charset OR -p word1 word2 ...
              Tells crunch to generate words that don’t have repeating charac‐
              ters.  By default  crunch  will  generate  a  wordlist  size  of
              #of_chars_in_charset  ^  max_length.   This  option will instead
              generate #of_chars_in_charset!.  The  !  stands  for  factorial.
              For example say the charset is abc and max length is 4..  Crunch
              will  by  default generate 3^4 = 81 words.  This option will in‐
              stead generate 3! = 3x2x1 = 6 words (abc, acb,  bac,  bca,  cab,
              cba).  THIS MUST BE THE LAST OPTION!  This option CANNOT be used
              with -s and it ignores min and max length however you must still
              specify two numbers.
              
       -q filename.txt
              Tells  crunch  to  read  filename.txt  and permute what is read.
              This is like the -p option except it gets the input  from  file‐
              name.txt.

       -r  Tells  crunch  to resume generate words from where it left off.  -r
              only works if you use -o.  You must use the same command as  the
              original command used to generate the words.  The only exception
              to  this is the -s option.  If your original command used the -s
              option you MUST remove it before you resume the  session.   Just
              add -r to the end of the original command.

       -s startblock
              Specifies a starting string, eg: 03god22fs

       -t @,%^
              Specifies  a pattern, eg: @@god@@@@ where the only the @’s, ,’s,
              %’s, and ^’s will change.
              @ will insert lower case characters
              , will insert upper case characters
              % will insert numbers
              ^ will insert symbols

       -u
              The -u option disables the printpercentage thread.  This  should
              be the last option.

       -z gzip, bzip2, lzma, and 7z
              Compresses  the output from the -o option.  Valid parameters are
              gzip, bzip2, lzma, and 7z.
              gzip is the fastest but the compression is minimal.  bzip2 is  a
              little slower than gzip but has better compression.  7z is slow‐
              est but has the best compression.

                    
                    ）',
                    "command" => 'crunch <min‐len> <max‐len> [<charset string>] [options]',
                    "examples" => array(
                        array(
                            "title" => "",
                            "describe" => "创建指定长度范围的字典文件（字典内容为纯数字组合）",
                            "command" => "crunch 6 11 0123456789 -o <字典文件保存路径>",
                        ),
                    ),
                ),
                "hashcat" => array(
                    "title" => 'hashcat : ',
                    "describe" => '密码解密渗透工具（
  
参数选项：
                    
-m   指定哈希类型

-a   指定攻击模式，有5中模式
    0 Straight（字典解密）
    1 Combination（组合解密）
    3 Brute-force（掩码暴力解密）
    6 Hybrid dict + mask（混合字典+掩码）
    7 Hybrid mask + dict（混合掩码+字典）
    
-o   输出文件

-stdout  指定基础文件

-r  指定规则文件

--force 强制进行解密

--show  显示解密结果
 
-V   打印出版本

-h   查看帮助
                    
                    ）',
                    "command" => 'hashcat [options]... hash|hashfile|hccapxfile [dictionary|mask|directory]...',
                    "examples" => array(
                        array(
                            "title" => "",
                            "describe" => "利用指定规则在当前目录下生成字典文件（--stdout 指定基础文件 -r 指定规则文件 -o 指定字典文件）",
                            "command" => "hashcat --stdout base.txt -r rules\dive.rule -o test.txt",
                        ),
                    ),
                ),
                "john" => array(
                    "title" => 'john : ',
                    "describe" => '密码解密渗透工具（
  
--help : 查看帮助信息；
                    
--single：简单解密（single crack）模式（根据账号名称进行解密，解密方式为：根据账号名称动态生成关联密码进行解密（一般是在获取的账号名称内容中追加其它字符串内容来进行解密））；

--wordlist=file --stdin：字典（wordlist crack）模式（通过指定的字典文件进行解密，或者通过--stdin接收的键盘输入内容进行解密）；

--rules：在字典（wordlist crack）模式下，启用字词规则变化功能（输入指定单词，通过包含指定单词的其它单词（包含输入的指定单词）进行解密（字词变化在john.ini文件中的[list.rules:wordlist]区域中进行设置）；

--incremental[=mode]：使用增强解密模式进行解密（mode为指定模式，原理为利用所有可能的字符生成字符组合序列，并将其当作密码进行解密。在john.ini文件中的[incremental:*****]区域内设置有许多模式，可以选择其中任一模式来进行密码解密））；

--external=mode：使用外挂模式进行解密（mode为指定模式，john软件使用者可以自己编写解密模式，并将其写入到john.ini文件中的[list.external:******]区域）；

--stdout[=mode]：显示john软件生成的密码字典（mode为指定模式，此选项与直接解密行为无关）；

--restore[=name]：继续之前被打断的解密进程（当密码解密工作被打断时，当前解密进度会被保存到名为john.rec的文件中。使用—restore参数选项可以从john.rec文件中读取之前进行解密行为时的中断位置，并继续进行解密操作）；

--session=name：设定当前解密进程的会话名称。此会话名称会在使用—restore参数进行解密进程恢复行为时用到，通过--session参数可以区分不同的解密进程）；

--status[=name]：显示解密进程列表中指定解密进程的工作状态（name为指定解密进程的会话名称）；

--make-charset=file：通过指定文件产生对应字符集；

--show：显示成功解密出的密码信息；

--test：测试当前各项解密工作的执行速度；

--users=[-]login|udi[,…]：此选项表示仅解密指定账号的密码（login为指定用户的账户名称，uid为指定用户的uid标识，login 和 uid 只能单选其一使用。当在 login 或 uid 之前添加“-”字符时，则表示不对 login 或 uid 对应账号执行解密操作）；

--groups=[-]gid[,….]：此选项表示仅解密指定用户组中所有用户的密码（gid为指定用户组标识，当在 gid 之前添加“-”字符时，则表示不对 gid 对应用户组下的所有用户执行解密操作）；  

--shells=[-]shell[,….]：此选项表示仅解密可以使用指定shell环境的用户的密码（shell指定shell环境名称(如bash、sh、csh等)，当在shell之前添加“-”字符时，则表示不对使用指定shell环境的用户进行密码解密操作）；

--salts=[-]count：仅解密satl（salt是unix/linux用来进行密码编码的基准单位）大于等于count的用户的密码（count为指定数目，这个选项可以获得较快的解密效率。当在count之前添加“-”字符时，则仅解密salt小于count的用户的密码）；

--format=name：指定使用何种密文格式进行解密（name为指定密文格式，取值范围：des、bsdi、md5、bf、afs、lm等）；

--save-memory=level：允许保存当前解密进程的内存快照（level为指定等级，取值范围：1、2、3等）      
                    
                    ）',
                    "command" => 'john [OPTIONS] [PASSWORD-FILES]',
                    "examples" => array(
                        array(
                            "title" => "",
                            "describe" => "单用户模式解密",
                            "command" => "sudo john --wordlist=/path/to/wordlist /path/to/password/file",
                        ),
                        array(
                            "title" => "",
                            "describe" => "多用户模式解密",
                            "command" => "sudo unshadow /etc/passwd /etc/shadow > passwords.txt && sudo john --wordlist=/path/to/wordlist passwords.txt",
                        ),
                        array(
                            "title" => "",
                            "describe" => "暴力解密",
                            "command" => "sudo john --incremental /path/to/password/file",
                        ),
                        array(
                            "title" => "",
                            "describe" => "彩虹表方式解密",
                            "command" => "sudo john --format=nt /path/to/password/file --pot=filename && sudo john --session=filename --restore",
                        ),
                    ),
                ),
                "medusa" => array(
                    "title" => 'medusa : ',
                    "describe" => '密码解密工具（参数选项 :           
                    
-h [TEXT]：目标主机名或IP地址；

-H [FILE]：设定需要使用的IP地址字典文件（IP地址字典文件的绝对路径）；

-u [TEXT]：要测试的账户名称；

-U [FILE]：设定需要使用的账户字典文件（账户字典文件的绝对路径）；

-p [TEXT]：要测试的密码；

-P [FILE]：设定需要使用的密码字典文件（密码字典文件的绝对路径）；

-C [FILE]：包含组合条目的文件（有关更多信息，请参阅README）；

-O [FILE]：设定用于保存日志信息的日志文件（日志文件的绝对路径）；

-e [n / s / ns]：其他密码检查（n 无密码，s 密码=用户名）；

-M [TEXT]：要执行的模块的名称（名称中不包含.mod扩展名）；

-m [TEXT]：传递给模块的参数（可以通过每次都传递不同的参数，将相应参数发送给指定模块（如，-m <参数1> -m <参数2>等））；

-d：转储所有已知的模块；

-n [NUM]：用于非默认的TCP端口号；

-s：启用SSL；

-g [NUM]：尝试连接NUM秒后放弃（默认为3）；

-r [NUM]：在重试尝试之间休眠NUM秒（默认值为3）；

-R [NUM]：尝试NUM在放弃之前重试（总尝试次数将是NUM + 1）；

-c [NUM]：在usec中等待以验证套接字的时间（默认值为500 usec）；

-t [NUM]：要同时测试的账户总数；

-T [NUM]：要同时测试的主机总数；

-L：每个线程使用一个用户名并行登录（默认是处理整个用户名在继续之前）；

-f：在找到第一个有效的用户名/密码后停止扫描主机；

-F：在任何主机上找到第一个有效的用户名/密码后停止审核；

-b：禁止启动横幅；

-q：显示模块的使用信息；

-v [NUM]：详细等级[0 - 6（更多）]；

-w [NUM]：错误调试级别[0 - 10（更多）]；

-V：显示版本；

-Z [TEXT]：根据上次扫描的地图继续扫描；
                    
                    ）',
                    "command" => 'medusa [-h host|-H file] [-u username|-U file] [-p password|-P file] [-C file] -M module [OPT]',
                    "examples" => array(
                        array(
                            "title" => "",
                            "describe" => "显示所有已安装的模块",
                            "command" => "medusa -d",
                        ),
                        array(
                            "title" => "",
                            "describe" => "显示指定模块的特定选项信息",
                            "command" => "medusa -M smbnt -q",
                        ),
                        array(
                            "title" => "",
                            "describe" => "利用SMB服务解密指定主机中指定账户的密码信息",
                            "command" => "medusa -h <IP地址> -u <用户名> -P <密码字典文件> -e ns -M smbnt",
                        ),
                        array(
                            "title" => "",
                            "describe" => "利用指定服务解密指定主机列表中指定账户列表的所有密码信息（注意，这可能会耗费很长时间！）",
                            "command" => "medusa -H <IP地址字典文件> -U <账户字典文件> -P <密码字典文件> -T <并行测试的主机总数（多线程）> -t <并行测试的账户总数（多线程）> -L -F -M <指定模块的名称>",
                        ),
                    ),
                ),
                "hydra" => array(
                    "title" => 'hydra : ',
                    "describe" => '开源的多功能解密工具（参数选项:

-l LOGIN or -L FILE  使用login名称登录，或从FILE加载多个登录；

-p PASS  or -P FILE  尝试密码PASS，或从FILE加载多个密码；

-C FILE   冒号分隔的“login:pass”格式，而不是-L/-P选项；

-M FILE   要测试的服务器列表，每行一个条目，“：”用于指定端口号；

-t TASKS  每个目标并行运行TASKS连接数（默认值：16） ；

-U        服务模块使用情况详细信息；

-m OPT    特定于模块的选项，有关信息，请参阅-U输出 ；

-h        更多命令行选项（COMPLETE HELP） ；

server    目标：DNS、IP或192.168.0.0/24（此选项或-M选项） ；

service   要破解的服务（请参阅下面的支持协议） ；

OPT       一些服务模块支持额外的输入（-U表示模块帮助）
                    
                    ）',
                    "command" => 'hydra [[[-l LOGIN|-L FILE] [-p PASS|-P FILE]] | [-C FILE]] [-e nsr] [-o FILE] [-t TASKS] [-M FILE [-T TASKS]] [-w TIME] [-W TIME] [-f] [-s PORT] [-x MIN:MAX:CHARSET] [-c TIME] [-ISOuvVd46] [-m MODULE_OPT] [service://server[:PORT][/OPT]]',
                    "examples" => array(
                        array(
                            "title" => "",
                            "describe" => "解密ssh",
                            "command" => "hydra -L <账户字典文件> -P <密码字典文件> -t 2 -vV -e ns <目标IP地址> ssh",
                        ),
                        array(
                            "title" => "",
                            "describe" => "解密ftp",
                            "command" => "hydra ip ftp -l <账户名称> -P <密码字典文件> -e ns -vV",
                        ),
                        array(
                            "title" => "",
                            "describe" => "解密teamspeak",
                            "command" => "hydra -l <账户名称> -P <密码字典文件> -s <指定端口号> -vV ip teamspeak",
                        ),
                        array(
                            "title" => "",
                            "describe" => "解密pop3",
                            "command" => "hydra -l <账户名称> -P <密码字典文件> <pop3服务器域名> pop3",
                        ),
                    ),
                ),
                "ncrack" => array(
                    "title" => 'ncrack : ',
                    "describe" => '网络认证解密工具（参数选项：
                    
TARGET SPECIFICATION:
  Can pass hostnames, IP addresses, networks, etc.
  Ex: scanme.nmap.org, microsoft.com/24, 192.168.0.1; 10.0.0-255.1-254
  -iX <inputfilename>: Input from Nmap\'s -oX XML output format
  -iN <inputfilename>: Input from Nmap\'s -oN Normal output format
  -iL <inputfilename>: Input from list of hosts/networks
  --exclude <host1[,host2][,host3],...>: Exclude hosts/networks
  --excludefile <exclude_file>: Exclude list from file
  
SERVICE SPECIFICATION:
  Can pass target specific services in <service>://target (standard) notation or
  using -p which will be applied to all hosts in non-standard notation.
  Service arguments can be specified to be host-specific, type of service-specific
  (-m) or global (-g). Ex: ssh://10.0.0.10,at=10,cl=30 -m ssh:at=50 -g cd=3000
  Ex2: ncrack -p ssh,ftp:3500,25 10.0.0.10 scanme.nmap.org google.com:80,ssl
  -p <service-list>: services will be applied to all non-standard notation hosts
  -m <service>:<options>: options will be applied to all services of this type
  -g <options>: options will be applied to every service globally
  
  Misc options:
    ssl: enable SSL over this service
    path <name>: used in modules like HTTP (\'=\' needs escaping if used)
    db <name>: used in modules like MongoDB to specify the database
    domain <name>: used in modules like WinRM to specify the domain
    
TIMING AND PERFORMANCE:
  Options which take <time> are in seconds, unless you append \'ms\'
  (milliseconds), \'m\' (minutes), or \'h\' (hours) to the value (e.g. 30m).
  Service-specific options:
    cl (min connection limit): minimum number of concurrent parallel connections
    CL (max connection limit): maximum number of concurrent parallel connections
    at (authentication tries): authentication attempts per connection
    cd (connection delay): delay <time> between each connection initiation
    cr (connection retries): caps number of service connection attempts
    to (time-out): maximum cracking <time> for service, regardless of success so far
  -T<0-5>: Set timing template (higher is faster)
  --connection-limit <number>: threshold for total concurrent connections
  --stealthy-linear: try credentials using only one connection against each specified host 
    until you hit the same host again. Overrides all other timing options.
    
AUTHENTICATION:
  -U <filename>: username file
  -P <filename>: password file
  --user <username_list>: comma-separated username list
  --pass <password_list>: comma-separated password list
  --passwords-first: Iterate password list for each username. Default is opposite.
  --pairwise: Choose usernames and passwords in pairs.
  
OUTPUT:
  -oN/-oX <file>: Output scan in normal and XML format, respectively, to the given filename.
  -oA <basename>: Output in the two major formats at once
  -v: Increase verbosity level (use twice or more for greater effect)
  -d[level]: Set or increase debugging level (Up to 10 is meaningful)
  --nsock-trace <level>: Set nsock trace level (Valid range: 0 - 10)
  --log-errors: Log errors/warnings to the normal-format output file
  --append-output: Append to rather than clobber specified output files
  
MISC:
  --resume <file>: Continue previously saved session
  --save <file>: Save restoration file with specific filename
  -f: quit cracking service after one found credential
  -6: Enable IPv6 cracking
  -sL or --list: only list hosts and services
  --datadir <dirname>: Specify custom Ncrack data file location
  --proxy <type://proxy:port>: Make connections via socks4, 4a, http.
  -V: Print version number
  -h: Print this help summary page.
  
MODULES:
  SSH, RDP, FTP, Telnet, HTTP(S), Wordpress, POP3(S), IMAP, CVS, SMB, VNC, SIP, Redis, PostgreSQL, MQTT, MySQL, MSSQL, MongoDB, Cassandra, WinRM, OWA, DICOM
  
EXAMPLES:
  ncrack -v --user root localhost:22
  ncrack -v -T5 https://192.168.0.1
  ncrack -v -iX ~/nmap.xml -g CL=5,to=1h
  
SEE THE MAN PAGE (http://nmap.org/ncrack/man.html) FOR MORE OPTIONS AND EXAMPLES                    
                    
                    ）',
                    "command" => 'ncrack [Options] {target and service specification}',
                    "examples" => array(
                        array(
                            "title" => "",
                            "describe" => "对指定IP地址的指定端口的指定账户进行密码测试",
                            "command" => "ncrack --user <账户名称> -P <密码字典文件> <目标IP地址:目标端口号>",
                        ),
                        array(
                            "title" => "",
                            "describe" => "对指定IP地址的指定端口的指定账户列表下的所有账户进行密码测试",
                            "command" => "ncrack -v -U <账户字典文件> -P <密码字典文件> <目标IP地址:目标端口号>",
                        ),
                    ),
                ),
                "ophcrack" => array(
                    "title" => 'ophcrack : ',
                    "describe" => '图形化的跨平台密码解密工具（使用彩虹表（ Table）破解哈希算法，彩虹表的原理为结合使用暴力法与查表法，在两种方法之间寻找平衡，在人类能够承受的计算时间和字典存储空间的条件下进行哈希算法解密）',
                    "command" => 'ophcrack',
                    "examples" => array(),
                ),
                "rainbowcrack" => array(
                    "title" => 'rainbowcrack : ',
                    "describe" => '密码解密工具（

使用方法：

rcrack path [path] [...] -l hash_list_file

rcrack path [path] [...] -lm pwdump_file

rcrack path [path] [...] -ntlm pwdump_file
                    
参数选项：

-h hash 加载单个hash；

-l hash_list_file 从文件中加载散列，每个散列在一行中；

-lm pwdump_file 从pwdump文件加载lm哈希；

-ntlm pwdump_file 从pwdump文件加载ntlm哈希；

实现的哈希算法：

lm HashLen=8 PlaintextLen=0-7

ntlm HashLen=16 PlaintextLen=0-15

md5 HashLen=16 PlaintextLen=0-15

sha1 HashLen=20 PlaintextLen=0-20

sha256 HashLen=32 PlaintextLen=0-20
                    
                    ）',
                    "command" => 'rcrack path <存储彩虹表（*.rt，*.rtc）的目录的绝对路径> [...] <选项参数名称> <选项参数值>',
                    "examples" => array(
                        array(
                            "title" => "",
                            "describe" => "使用单个哈希值进行解密工作（这里的 . 表示存储彩虹表的目录为当前目录）",
                            "command" => "rcrack . -h 5d41402abc4b2a76b9719d911017c592",
                        ),
                        array(
                            "title" => "",
                            "describe" => "使用哈希值字典文件进行解密工作（这里的 . 表示存储彩虹表的目录为当前目录）",
                            "command" => "rcrack . -l hash.txt",
                        ),
                    ),
                ),
                "wordlists" => array(
                    "title" => 'wordlists : ',
                    "describe" => 'kali linux 自带字典（
                    
字典文件列表：

/usr/share/wordlists
├── amass -> /usr/share/amass/wordlists
├── dirb -> /usr/share/dirb/wordlists
├── dirbuster -> /usr/share/dirbuster/wordlists
├── fasttrack.txt -> /usr/share/set/src/fasttrack/wordlist.txt
├── fern-wifi -> /usr/share/fern-wifi-cracker/extras/wordlists
├── john.lst -> /usr/share/john/password.lst
├── legion -> /usr/share/legion/wordlists
├── metasploit -> /usr/share/metasploit-framework/data/wordlists
├── nmap.lst -> /usr/share/nmap/nselib/data/passwords.lst
├── rockyou.txt
├── seclists -> /usr/share/seclists
├── sqlmap.txt -> /usr/share/sqlmap/data/txt/wordlist.txt
├── wfuzz -> /usr/share/wfuzz/wordlist
└── wifite.txt -> /usr/share/dict/wordlist-probable.txt
                    
                    ）',
                    "command" => 'ls -l /usr/share/wordlists',
                    "examples" => array(),
                ),
            ),
        );
        Class_Base_Auth::check_permission();
        if (!is_cli()) {
            $_form_top = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Password Attack Commands</div>';
            $_form = array(
                "action" => "/guide/penetration_test_commands",
                "inputs" => array(),
                "textareas" => array(),
                "submit" => array(
                    "value" => " return to Penetration Test Commands ",
                    "display" => true,
                ),
                "reset" => array(
                    "display" => false,
                ),
            );
            self::_commands_format_to_form_textareas($_common_commands, $_form);
            $_top = Class_View_Top::top();
            $_body = array(
                "menu" => Class_View_Guide_PenetrationTestCommands_Menu::menu(),
                "content" => (($_form_top) . Class_View::form_body($_form)),
            );
            $_bottom = Class_View_Bottom::bottom();
            Class_Base_Response::output(Class_View::index($_top, $_body, $_bottom), "text", 0);
        }
        return null;
    }

    public static function wireless_attacks($params = array())
    {
        if ((!is_cli()) && (!Class_Base_Auth::is_login())) {
            Class_Base_Response::redirect("/login");
            return null;
        }
        $_common_commands = array(
            "wireless_attacks" => array(
                "aircrack-ng" => array(
                    "title" => 'aircrack-ng : ',
                    "describe" => '基于802.11标准的进行无线网络分析的安全软件（
                    
  Common options:


      -a <amode> : force attack mode (1/WEP, 2/WPA-PSK)
      
      -e <essid> : target selection: network identifier
      
      -b <bssid> : target selection: access point\'s MAC
      
      -p <nbcpu> : # of CPU to use  (default: all CPUs)
      
      -q         : enable quiet mode (no status output)
      
      -C <macs>  : merge the given APs to a virtual one
      
      -l <file>  : write key to file. Overwrites file.
      

  Static WEP cracking options:


      -c         : search alpha-numeric characters only
      
      -t         : search binary coded decimal chr only
      
      -h         : search the numeric key for Fritz!BOX
      
      -d <mask>  : use masking of the key (A1:XX:CF:YY)
      
      -m <maddr> : MAC address to filter usable packets
      
      -n <nbits> : WEP key length :  64/128/152/256/512
      
      -i <index> : WEP key index (1 to 4), default: any
      
      -f <fudge> : bruteforce fudge factor,  default: 2
      
      -k <korek> : disable one attack method  (1 to 17)
      
      -x or -x0  : disable bruteforce for last keybytes
      
      -x1        : last keybyte bruteforcing  (default)
      
      -x2        : enable last  2 keybytes bruteforcing
      
      -X         : disable  bruteforce   multithreading
      
      -y         : experimental  single bruteforce mode
      
      -K         : use only old KoreK attacks (pre-PTW)
      
      -s         : show the key in ASCII while cracking
      
      -M <num>   : specify maximum number of IVs to use
      
      -D         : WEP decloak, skips broken keystreams
      
      -P <num>   : PTW debug:  1: disable Klein, 2: PTW
      
      -1         : run only 1 try to crack key with PTW
      
      -V         : run in visual inspection mode


  WEP and WPA-PSK cracking options:

      -w <words> : path to wordlist(s) filename(s)
      
      -N <file>  : path to new session filename
      
      -R <file>  : path to existing session filename
      

  WPA-PSK options:

      -E <file>  : create EWSA Project file v3
      
      -I <str>   : PMKID string (hashcat -m 16800)
      
      -j <file>  : create Hashcat v3.6+ file (HCCAPX)
      
      -J <file>  : create Hashcat file (HCCAP)
      
      -S         : WPA cracking speed test
      
      -Z <sec>   : WPA cracking speed test length of execution.
      
      -r <DB>    : path to airolib-ng database (Cannot be used with -w)

  SIMD selection:

      --simd-list       : Show a list of the available SIMD architectures, for this machine.
      
      --simd=<option>   : Use specific SIMD architecture.

      <option> may be one of the following, depending on your platform:

                   generic
                   avx512
                   avx2
                   avx
                   sse2
                   altivec
                   power8
                   asimd
                   neon


  Other options:

      -u         : Displays # of CPUs & SIMD support
      
      --help     : Displays this usage screen   
                    
                    ）',
                    "command" => 'aircrack-ng [options] <input file(s)>',
                    "examples" => array(),
                ),
                "cowpatty" => array(
                    "title" => 'cowpatty : ',
                    "describe" => '无线解密工具（WPA-PSK）（
                    
options:

	-f 	Dictionary file
	
	-d 	Hash file (genpmk)
	
	-r 	Packet capture file
	
	-s 	Network SSID (enclose in quotes if SSID includes spaces)
	
	-c 	Check for valid 4-way frames, does not crack
	
	-h 	Print this help information and exit
	
	-v 	Print verbose information (more -v for more verbosity)
	
	-V 	Print program version and exit
                    
                    ）',
                    "command" => 'cowpatty [options]',
                    "examples" => array(),
                ),
                "fern-wifi-crack ( root ) " => array(
                    "title" => 'fern-wifi-crack ( root ) : ',
                    "describe" => '无线安全审计测试软件（图形化界面）',
                    "command" => 'fern-wifi-crack',
                    "examples" => array(),
                ),
                "kismet" => array(
                    "title" => 'kismet : ',
                    "describe" => '无线网络嗅探工具（
                    
 *** Generic Options ***
 
 -v, --version                Show version
 
 -h  --help                   Display this help message
 
     --no-console-wrapper     Disable server console wrapper
     
     --no-ncurses-wrapper     Disable server console wrapper
     
     --no-ncurses             Disable server console wrapper
     
     --debug                  Disable the console wrapper and the crash handling functions, for debugging
     
 -c <datasource>              Use the specified datasource
 
 -f, --config-file <file>     Use alternate configuration file
 
     --no-line-wrap           Turn off linewrapping of output (for grep, speed, etc)
     
 -s, --silent                 Turn off stdout output after setup phase
 
     --daemonize              Spawn detached in the background
     
     --no-plugins             Do not load plugins
     
     --homedir <path>         Use an alternate path as the home directory instead of the user entry
     
     --confdir <path>         Use an alternate path as the base config directory instead of the default set at compile time
     
     --datadir <path>         Use an alternate path as the data directory instead of the default set at compile time.
     
     --override <flavor>      Load an alternate configuration override from {confdir}/kismet_{flavor}.conf or as a specific override file.
     
     
 *** Logging Options ***
 
 
 -T, --log-types <types>      Override activated log types
 
 -t, --log-title <title>      Override default log title
 
 -p, --log-prefix <prefix>    Directory to store log files
 
 -n, --no-logging             Disable logging entirely


 *** Device Tracking Options ***
 
     --device-timeout=n       Expire devices after N seconds
                    
                    ）',
                    "command" => 'kismet [OPTION]',
                    "examples" => array(),
                ),
                "pixiewps" => array(
                    "title" => 'pixiewps : ',
                    "describe" => '无线破解工具（
                    
 Required arguments:

   -e, --pke         : Enrollee public key
   
   -r, --pkr         : Registrar public key
   
   -s, --e-hash1     : Enrollee hash-1
   
   -z, --e-hash2     : Enrollee hash-2
   
   -a, --authkey     : Authentication session key
   
   -n, --e-nonce     : Enrollee nonce
   

 Optional arguments:

   -m, --r-nonce     : Registrar nonce
   
   -b, --e-bssid     : Enrollee BSSID
   
   -v, --verbosity   : Verbosity level 1-3, 1 is quietest           [3]
   
   -o, --output      : Write output to file
   
   -j, --jobs        : Number of parallel threads to use         [Auto]

   -h                : Display this usage screen
   
   --help            : Verbose help and more usage examples
   
   -V, --version     : Display version

   --mode N[,... N]  : Mode selection, comma separated           [Auto]
   
   --start [mm/]yyyy : Starting date             (only mode 3) [+1 day]
   
   --end   [mm/]yyyy : Ending date               (only mode 3) [-1 day]
   
   -f, --force       : Bruteforce full range     (only mode 3)


 Miscellaneous arguments:

   -7, --m7-enc      : Recover encrypted settings from M7 (only mode 3)
   
   -5, --m5-enc      : Recover secret nonce from M5       (only mode 3)


 Example (use --help for more):

 pixiewps -e <pke> -r <pkr> -s <e-hash1> -z <e-hash2> -a <authkey> -n <e-nonce>                   
                    
                    ）',
                    "command" => 'pixiewps <arguments>',
                    "examples" => array(),
                ),
                "reaver" => array(
                    "title" => 'reaver : ',
                    "describe" => 'WiFi保护设置渗透工具（
                    
Required Arguments:

	-i, --interface=<wlan>          Name of the monitor-mode interface to use
	
	-b, --bssid=<mac>               BSSID of the target AP


Optional Arguments:

	-m, --mac=<mac>                 MAC of the host system
	
	-e, --essid=<ssid>              ESSID of the target AP
	
	-c, --channel=<channel>         Set the 802.11 channel for the interface (implies -f)
	
	-s, --session=<file>            Restore a previous session file
	
	-C, --exec=<command>            Execute the supplied command upon successful pin recovery
	
	-f, --fixed                     Disable channel hopping
	
	-5, --5ghz                      Use 5GHz 802.11 channels
	
	-v, --verbose                   Display non-critical warnings (-vv or -vvv for more)
	
	-q, --quiet                     Only display critical messages
	
	-h, --help                      Show help


Advanced Options:

	-p, --pin=<wps pin>             Use the specified pin (may be arbitrary string or 4/8 digit WPS pin)
	
	-d, --delay=<seconds>           Set the delay between pin attempts [1]
	
	-l, --lock-delay=<seconds>      Set the time to wait if the AP locks WPS pin attempts [60]
	
	-g, --max-attempts=<num>        Quit after num pin attempts
	
	-x, --fail-wait=<seconds>       Set the time to sleep after 10 unexpected failures [0]
	
	-r, --recurring-delay=<x:y>     Sleep for y seconds every x pin attempts
	
	-t, --timeout=<seconds>         Set the receive timeout period [10]
	
	-T, --m57-timeout=<seconds>     Set the M5/M7 timeout period [0.40]
	
	-A, --no-associate              Do not associate with the AP (association must be done by another application)
	
	-N, --no-nacks                  Do not send NACK messages when out of order packets are received
	
	-S, --dh-small                  Use small DH keys to improve crack speed
	
	-L, --ignore-locks              Ignore locked state reported by the target AP
	
	-E, --eap-terminate             Terminate each WPS session with an EAP FAIL packet
	
	-J, --timeout-is-nack           Treat timeout as NACK (DIR-300/320)
	
	-F, --ignore-fcs                Ignore frame checksum errors
	
	-w, --win7                      Mimic a Windows 7 registrar [False]
	
	-K, --pixie-dust                Run pixiedust attack
	
	-Z                              Run pixiedust attack
	
	-O, --output-file=<filename>    Write packets of interest into pcap file


Example:

	reaver -i wlan0mon -b 00:90:4C:C1:AC:21 -vv   
                    
                    ）',
                    "command" => 'reaver -h',
                    "examples" => array(),
                ),
                "wifite" => array(
                    "title" => 'wifite : ',
                    "describe" => '自动化wep、wpa解密工具（
                    
options:

  -h, --help                                 show this help message and exit


SETTINGS:

  -v, --verbose                              Shows more options (-h -v). Prints commands and outputs. (default: quiet)
  
  -i [interface]                             Wireless interface to use, e.g. wlan0mon (default: ask)
  
  -c [channel]                               Wireless channel to scan e.g. 1,3-6 (default: all 2Ghz channels)
  
  -inf, --infinite                           Enable infinite attack mode. Modify scanning time with -p (default: off)
  
  -mac, --random-mac                         Randomize wireless card MAC address (default: off)
  
  -p [scan_time]                             Pillage: Attack all targets after scan_time (seconds)
  
  --kill                                     Kill processes that conflict with Airmon/Airodump (default: off)
  
  -pow [min_power], --power [min_power]      Attacks any targets with at least min_power signal strength
  
  --skip-crack                               Skip cracking captured handshakes/pmkid (default: off)
  
  -first [attack_max], --first [attack_max]  Attacks the first attack_max targets
  
  -ic, --ignore-cracked                      Hides previously-cracked targets. (default: off)
  
  --clients-only                             Only show targets that have associated clients (default: off)
  
  --nodeauths                                Passive mode: Never deauthenticates clients (default: deauth targets)
  
  --daemon                                   Puts device back in managed mode after quitting (default: off)


WEP:

  --wep                                      Show only WEP-encrypted networks
  
  --require-fakeauth                         Fails attacks if fake-auth fails (default: off)
  
  --keep-ivs                                 Retain .IVS files and reuse when cracking (default: off)
  

WPA:

  --wpa                                      Show only WPA-encrypted networks (includes WPS)
  
  --new-hs                                   Captures new handshakes, ignores existing handshakes in hs (default: off)
  
  --dict [file]                              File containing passwords for cracking (default: /usr/share/dict/wordlist-probable.txt)
  

WPS:

  --wps                                      Show only WPS-enabled networks
  
  --wps-only                                 Only use WPS PIN & Pixie-Dust attacks (default:
                                             off)
  --bully                                    Use bully program for WPS PIN & Pixie-Dust attacks (default:
                                             reaver)
  --reaver                                   Use reaver program for WPS PIN & Pixie-Dust attacks (default:
                                             reaver)
  --ignore-locks                             Do not stop WPS PIN attack if AP becomes locked (default:
                                             stop)

PMKID:

  --pmkid                                    Only use PMKID capture, avoids other WPS & WPA attacks (default: off)
  
  --no-pmkid                                 Don\'t use PMKID capture (default: off)
  
  --pmkid-timeout [sec]                      Time to wait for PMKID capture (default: 300 seconds)


COMMANDS:

  --cracked                                  Print previously-cracked access points
  
  --check [file]                             Check a .cap file (or all hs/*.cap files) for WPA handshakes
  
  --crack                                    Show commands to crack a captured handshake    
                    
                    ）',
                    "command" => 'wifite --help',
                    "examples" => array(),
                ),
            ),
        );
        Class_Base_Auth::check_permission();
        if (!is_cli()) {
            $_form_top = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Wireless Attacks Commands</div>';
            $_form = array(
                "action" => "/guide/penetration_test_commands",
                "inputs" => array(),
                "textareas" => array(),
                "submit" => array(
                    "value" => " return to Penetration Test Commands ",
                    "display" => true,
                ),
                "reset" => array(
                    "display" => false,
                ),
            );
            self::_commands_format_to_form_textareas($_common_commands, $_form);
            $_top = Class_View_Top::top();
            $_body = array(
                "menu" => Class_View_Guide_PenetrationTestCommands_Menu::menu(),
                "content" => (($_form_top) . Class_View::form_body($_form)),
            );
            $_bottom = Class_View_Bottom::bottom();
            Class_Base_Response::output(Class_View::index($_top, $_body, $_bottom), "text", 0);
        }
        return null;
    }

    public static function reverse_engineering($params = array())
    {
        if ((!is_cli()) && (!Class_Base_Auth::is_login())) {
            Class_Base_Response::redirect("/login");
            return null;
        }
        $_common_commands = array(
            "reverse_engineering" => array(
                "clang" => array(
                    "title" => 'clang : ',
                    "describe" => '一个C语言、C++、Objective-C语言的轻量级编译器（
                    
OPTIONS:
  -###                    Print (but do not run) the commands to run for this compilation
  --amdgpu-arch-tool=<value>
                          Tool used for detecting AMD GPU arch in the system.
  --analyzer-output <value>
                          Static analyzer report output format (html|plist|plist-multi-file|plist-html|sarif|sarif-html|text).
  --analyze               Run the static analyzer
  -arcmt-migrate-emit-errors
                          Emit ARC errors even if the migrator can fix them
  -arcmt-migrate-report-output <value>
                          Output path for the plist report
  -B <prefix>             Search $prefix$file for executables, libraries, and data files. If $prefix is a directory, search $prefix/$file
  -b <arg>                Pass -b <arg> to the linker on AIX (only).
  -CC                     Include comments from within macros in preprocessed output
  -cl-denorms-are-zero    OpenCL only. Allow denormals to be flushed to zero.
  -cl-fast-relaxed-math   OpenCL only. Sets -cl-finite-math-only and -cl-unsafe-math-optimizations, and defines __FAST_RELAXED_MATH__.
  -cl-finite-math-only    OpenCL only. Allow floating-point optimizations that assume arguments and results are not NaNs or +-Inf.
  -cl-fp32-correctly-rounded-divide-sqrt
                          OpenCL only. Specify that single precision floating-point divide and sqrt used in the program source are correctly rounded.
  -cl-kernel-arg-info     OpenCL only. Generate kernel argument metadata.
  -cl-mad-enable          OpenCL only. Allow use of less precise MAD computations in the generated binary.
  -cl-no-signed-zeros     OpenCL only. Allow use of less precise no signed zeros computations in the generated binary.
  -cl-no-stdinc           OpenCL only. Disables all standard includes containing non-native compiler types and functions.
  -cl-opt-disable         OpenCL only. This option disables all optimizations. By default optimizations are enabled.
  -cl-single-precision-constant
                          OpenCL only. Treat double precision floating-point constant as single precision constant.
  -cl-std=<value>         OpenCL language standard to compile for.
  -cl-strict-aliasing     OpenCL only. This option is added for compatibility with OpenCL 1.0.
  -cl-uniform-work-group-size
                          OpenCL only. Defines that the global work-size be a multiple of the work-group size specified to clEnqueueNDRangeKernel
  -cl-unsafe-math-optimizations
                          OpenCL only. Allow unsafe floating-point optimizations.  Also implies -cl-no-signed-zeros and -cl-mad-enable.
  --config <value>        Specifies configuration file
  --cuda-compile-host-device
                          Compile CUDA code for both host and device (default).  Has no effect on non-CUDA compilations.
  --cuda-device-only      Compile CUDA code for device only
  --cuda-host-only        Compile CUDA code for host only.  Has no effect on non-CUDA compilations.
  --cuda-include-ptx=<value>
                          Include PTX for the following GPU architecture (e.g. sm_35) or \'all\'. May be specified more than once.
  --cuda-noopt-device-debug
                          Enable device-side debug info generation. Disables ptxas optimizations.
  --cuda-path-ignore-env  Ignore environment variables to detect CUDA installation
  --cuda-path=<value>     CUDA installation path
  -cuid=<value>           An ID for compilation unit, which should be the same for the same compilation unit but different for different compilation units. It is used to externalize device-side static variables for single source offloading languages CUDA and HIP so that they can be accessed by the host code of the same compilation unit.
  -cxx-isystem <directory>
                          Add directory to the C++ SYSTEM include search path
  -C                      Include comments in preprocessed output
  -c                      Only run preprocess, compile, and assemble steps
  -dD                     Print macro definitions in -E mode in addition to normal output
  -dependency-dot <value> Filename to write DOT-formatted header dependencies to
  -dependency-file <value>
                          Filename (or -) to write dependency output to
  -dI                     Print include directives in -E mode in addition to normal output
  -dM                     Print macro definitions in -E mode instead of normal output
  -dsym-dir <dir>         Directory to output dSYM\'s (if any) to
  -D <macro>=<value>      Define <macro> to <value> (or 1 if <value> omitted)
  -emit-ast               Emit Clang AST files for source inputs
  -emit-interface-stubs   Generate Interface Stub Files.
  -emit-llvm              Use the LLVM representation for assembler and object files
  -emit-merged-ifs        Generate Interface Stub Files, emit merged text not binary.
  --emit-static-lib       Enable linker job to emit a static library.
  -enable-trivial-auto-var-init-zero-knowing-it-will-be-removed-from-clang
                          Trivial automatic variable initialization to zero is only here for benchmarks, it\'ll eventually be removed, and I\'m OK with that because I\'m only using it to benchmark
  --end-no-unused-arguments
                          Start emitting warnings for unused driver arguments
  -extract-api            Extract API information
  -E                      Only run the preprocessor
  -faapcs-bitfield-load   Follows the AAPCS standard that all volatile bit-field write generates at least one load. (ARM only).
  -faapcs-bitfield-width  Follow the AAPCS standard requirement stating that volatile bit-field width is dictated by the field container type. (ARM only).
  -faddrsig               Emit an address-significance table
  -falign-loops=<N>       N must be a power of two. Align loops to the boundary
  -faligned-allocation    Enable C++17 aligned allocation functions
  -fallow-editor-placeholders
                          Treat editor placeholders as valid source code
  -faltivec-src-compat=<value>
                          Source-level compatibility for Altivec vectors (for PowerPC targets). This includes results of vector comparison (scalar for \'xl\', vector for \'gcc\') as well as behavior when initializing with a scalar (splatting for \'xl\', element zero only for \'gcc\'). For \'mixed\', the compatibility is as \'gcc\' for \'vector bool/vector pixel\' and as \'xl\' for other types. Current default is \'mixed\'.
  -fansi-escape-codes     Use ANSI escape codes for diagnostics
  -fapple-kext            Use Apple\'s kernel extensions ABI
  -fapple-link-rtlib      Force linking the clang builtins runtime library
  -fapple-pragma-pack     Enable Apple gcc-compatible #pragma pack handling
  -fapplication-extension Restrict code to those available for App Extensions
  -fapprox-func           Allow certain math function calls to be replaced with an approximately equivalent calculation
  -fasync-exceptions      Enable EH Asynchronous exceptions
  -fbasic-block-sections=<value>
                          Place each function\'s basic blocks in unique sections (ELF Only) : all | labels | none | list=<file>
  -fbinutils-version=<major.minor>
                          Produced object files can use all ELF features supported by this binutils version and newer. If -fno-integrated-as is specified, the generated assembly will consider GNU as support. \'none\' means that all ELF features can be used, regardless of binutils support. Defaults to 2.26.
  -fblocks                Enable the \'blocks\' language feature
  -fborland-extensions    Accept non-standard constructs supported by the Borland compiler
  -fbuild-session-file=<file>
                          Use the last modification time of <file> as the build session timestamp
  -fbuild-session-timestamp=<time since Epoch in seconds>
                          Time when the current build session started
  -fbuiltin-module-map    Load the clang builtins module map file.
  -fc++-abi=<value>       C++ ABI to use. This will override the target C++ ABI.
  -fcall-saved-x10        Make the x10 register call-saved (AArch64 only)
  -fcall-saved-x11        Make the x11 register call-saved (AArch64 only)
  -fcall-saved-x12        Make the x12 register call-saved (AArch64 only)
  -fcall-saved-x13        Make the x13 register call-saved (AArch64 only)
  -fcall-saved-x14        Make the x14 register call-saved (AArch64 only)
  -fcall-saved-x15        Make the x15 register call-saved (AArch64 only)
  -fcall-saved-x18        Make the x18 register call-saved (AArch64 only)
  -fcall-saved-x8         Make the x8 register call-saved (AArch64 only)
  -fcall-saved-x9         Make the x9 register call-saved (AArch64 only)
  -fcf-protection=<value> Instrument control-flow architecture protection. Options: return, branch, full, none.
  -fcf-protection         Enable cf-protection in \'full\' mode
  -fchar8_t               Enable C++ builtin type char8_t
  -fclang-abi-compat=<version>
                          Attempt to match the ABI of Clang <version>
  -fcolor-diagnostics     Enable colors in diagnostics
  -fcomment-block-commands=<arg>
                          Treat each comma separated argument in <arg> as a documentation comment block command
  -fcommon                Place uninitialized global variables in a common block
  -fcomplete-member-pointers
                          Require member pointer base types to be complete if they would be significant under the Microsoft ABI
  -fconvergent-functions  Assume functions may be convergent
  -fcoroutines-ts         Enable support for the C++ Coroutines TS
  -fcoverage-compilation-dir=<value>
                          The compilation directory to embed in the coverage mapping.
  -fcoverage-mapping      Generate coverage mapping to enable code coverage analysis
  -fcoverage-prefix-map=<value>
                          remap file source paths in coverage mapping
  -fcrash-diagnostics-dir=<dir>
                          Put crash-report files in <dir>
  -fcs-profile-generate=<directory>
                          Generate instrumented code to collect context sensitive execution counts into <directory>/default.profraw (overridden by LLVM_PROFILE_FILE env var)
  -fcs-profile-generate   Generate instrumented code to collect context sensitive execution counts into default.profraw (overridden by LLVM_PROFILE_FILE env var)
  -fcuda-approx-transcendentals
                          Use approximate transcendental functions
  -fcuda-short-ptr        Use 32-bit pointers for accessing const/local/shared address spaces
  -fcxx-exceptions        Enable C++ exceptions
  -fcxx-modules           Enable modules for C++
  -fdata-sections         Place each data in its own section
  -fdebug-compilation-dir=<value>
                          The compilation directory to embed in the debug info
  -fdebug-default-version=<value>
                          Default DWARF version to use, if a -g option caused DWARF debug info to be produced
  -fdebug-info-for-profiling
                          Emit extra debug info to make sample profile more accurate
  -fdebug-macro           Emit macro debug information
  -fdebug-prefix-map=<value>
                          remap file source paths in debug info
  -fdebug-ranges-base-address
                          Use DWARF base address selection entries in .debug_ranges
  -fdebug-types-section   Place debug types in their own section (ELF Only)
  -fdeclspec              Allow __declspec as a keyword
  -fdelayed-template-parsing
                          Parse templated function definitions at the end of the translation unit
  -fdelete-null-pointer-checks
                          Treat usage of null pointers as undefined behavior (default)
  -fdiagnostics-absolute-paths
                          Print absolute paths in diagnostics
  -fdiagnostics-hotness-threshold=<value>
                          Prevent optimization remarks from being output if they do not have at least this profile count. Use \'auto\' to apply the threshold from profile summary
  -fdiagnostics-parseable-fixits
                          Print fix-its in machine parseable form
  -fdiagnostics-print-source-range-info
                          Print source range spans in numeric form
  -fdiagnostics-show-hotness
                          Enable profile hotness information in diagnostic line
  -fdiagnostics-show-note-include-stack
                          Display include stacks for diagnostic notes
  -fdiagnostics-show-option
                          Print option name with mappable diagnostics
  -fdiagnostics-show-template-tree
                          Print a template comparison tree for differing templates
  -fdigraphs              Enable alternative token representations \'<:\', \':>\', \'<%\', \'%>\', \'%:\', \'%:%:\' (default)
  -fdirect-access-external-data
                          Don\'t use GOT indirection to reference external data symbols
  -fdiscard-value-names   Discard value names in LLVM IR
  -fdollars-in-identifiers
                          Allow \'$\' in identifiers
  -fdouble-square-bracket-attributes
                          Enable \'[[]]\' attributes in all C and C++ language modes
  -fdwarf-exceptions      Use DWARF style exceptions
  -feliminate-unused-debug-types
                          Do not emit  debug info for defined but unused types
  -fembed-bitcode-marker  Embed placeholder LLVM IR data as a marker
  -fembed-bitcode=<option>
                          Embed LLVM bitcode (option: off, all, bitcode, marker)
  -fembed-bitcode         Embed LLVM IR bitcode as data
  -fembed-offload-object=<value>
                          Embed Offloading device-side binary into host object file as a section.
  -femit-all-decls        Emit all declarations, even if unused
  -femulated-tls          Use emutls functions to access thread_local variables
  -fenable-matrix         Enable matrix data type and related builtin functions
  -fexceptions            Enable support for exception handling
  -fexperimental-new-constant-interpreter
                          Enable the experimental new constant interpreter
  -fexperimental-relative-c++-abi-vtables
                          Use the experimental C++ class ABI for classes with virtual tables
  -fexperimental-strict-floating-point
                          Enables experimental strict floating point in LLVM.
  -fextend-arguments=<value>
                          Controls how scalar integer arguments are extended in calls to unprototyped and varargs functions
  -ffast-math             Allow aggressive, lossy floating-point optimizations
  -ffile-compilation-dir=<value>
                          The compilation directory to embed in the debug info and coverage mapping.
  -ffile-prefix-map=<value>
                          remap file source paths in debug info, predefined preprocessor macros and __builtin_FILE()
  -ffine-grained-bitfield-accesses
                          Use separate accesses for consecutive bitfield runs with legal widths and alignments.
  -ffinite-loops          Assume all loops are finite.
  -ffixed-a0              Reserve the a0 register (M68k only)
  -ffixed-a1              Reserve the a1 register (M68k only)
  -ffixed-a2              Reserve the a2 register (M68k only)
  -ffixed-a3              Reserve the a3 register (M68k only)
  -ffixed-a4              Reserve the a4 register (M68k only)
  -ffixed-a5              Reserve the a5 register (M68k only)
  -ffixed-a6              Reserve the a6 register (M68k only)
  -ffixed-d0              Reserve the d0 register (M68k only)
  -ffixed-d1              Reserve the d1 register (M68k only)
  -ffixed-d2              Reserve the d2 register (M68k only)
  -ffixed-d3              Reserve the d3 register (M68k only)
  -ffixed-d4              Reserve the d4 register (M68k only)
  -ffixed-d5              Reserve the d5 register (M68k only)
  -ffixed-d6              Reserve the d6 register (M68k only)
  -ffixed-d7              Reserve the d7 register (M68k only)
  -ffixed-point           Enable fixed point types
  -ffixed-r19             Reserve register r19 (Hexagon only)
  -ffixed-r9              Reserve the r9 register (ARM only)
  -ffixed-x10             Reserve the x10 register (AArch64/RISC-V only)
  -ffixed-x11             Reserve the x11 register (AArch64/RISC-V only)
  -ffixed-x12             Reserve the x12 register (AArch64/RISC-V only)
  -ffixed-x13             Reserve the x13 register (AArch64/RISC-V only)
  -ffixed-x14             Reserve the x14 register (AArch64/RISC-V only)
  -ffixed-x15             Reserve the x15 register (AArch64/RISC-V only)
  -ffixed-x16             Reserve the x16 register (AArch64/RISC-V only)
  -ffixed-x17             Reserve the x17 register (AArch64/RISC-V only)
  -ffixed-x18             Reserve the x18 register (AArch64/RISC-V only)
  -ffixed-x19             Reserve the x19 register (AArch64/RISC-V only)
  -ffixed-x1              Reserve the x1 register (AArch64/RISC-V only)
  -ffixed-x20             Reserve the x20 register (AArch64/RISC-V only)
  -ffixed-x21             Reserve the x21 register (AArch64/RISC-V only)
  -ffixed-x22             Reserve the x22 register (AArch64/RISC-V only)
  -ffixed-x23             Reserve the x23 register (AArch64/RISC-V only)
  -ffixed-x24             Reserve the x24 register (AArch64/RISC-V only)
  -ffixed-x25             Reserve the x25 register (AArch64/RISC-V only)
  -ffixed-x26             Reserve the x26 register (AArch64/RISC-V only)
  -ffixed-x27             Reserve the x27 register (AArch64/RISC-V only)
  -ffixed-x28             Reserve the x28 register (AArch64/RISC-V only)
  -ffixed-x29             Reserve the x29 register (AArch64/RISC-V only)
  -ffixed-x2              Reserve the x2 register (AArch64/RISC-V only)
  -ffixed-x30             Reserve the x30 register (AArch64/RISC-V only)
  -ffixed-x31             Reserve the x31 register (AArch64/RISC-V only)
  -ffixed-x3              Reserve the x3 register (AArch64/RISC-V only)
  -ffixed-x4              Reserve the x4 register (AArch64/RISC-V only)
  -ffixed-x5              Reserve the x5 register (AArch64/RISC-V only)
  -ffixed-x6              Reserve the x6 register (AArch64/RISC-V only)
  -ffixed-x7              Reserve the x7 register (AArch64/RISC-V only)
  -ffixed-x8              Reserve the x8 register (AArch64/RISC-V only)
  -ffixed-x9              Reserve the x9 register (AArch64/RISC-V only)
  -fforce-dwarf-frame     Always emit a debug frame section
  -fforce-emit-vtables    Emits more virtual tables to improve devirtualization
  -fforce-enable-int128   Enable support for int128_t type
  -ffp-contract=<value>   Form fused FP ops (e.g. FMAs): fast (fuses across statements disregarding pragmas) | on (only fuses in the same statement unless dictated by pragmas) | off (never fuses) | fast-honor-pragmas (fuses across statements unless diectated by pragmas). Default is \'fast\' for CUDA, \'fast-honor-pragmas\' for HIP, and \'on\' otherwise.
  -ffp-exception-behavior=<value>
                          Specifies the exception behavior of floating-point operations.
  -ffp-model=<value>      Controls the semantics of floating-point calculations.
  -ffreestanding          Assert that the compilation takes place in a freestanding environment
  -ffuchsia-api-level=<value>
                          Set Fuchsia API level
  -ffunction-sections     Place each function in its own section
  -fglobal-isel           Enables the global instruction selector
  -fgnu-keywords          Allow GNU-extension keywords regardless of language standard
  -fgnu-runtime           Generate output compatible with the standard GNU Objective-C runtime
  -fgnu89-inline          Use the gnu89 inline semantics
  -fgnuc-version=<value>  Sets various macros to claim compatibility with the given GCC version (default is 4.2.1)
  -fgpu-allow-device-init Allow device side init function in HIP (experimental)
  -fgpu-defer-diag        Defer host/device related diagnostic messages for CUDA/HIP
  -fgpu-flush-denormals-to-zero
                          Flush denormal floating point values to zero in CUDA/HIP device mode.
  -fgpu-rdc               Generate relocatable device code, also known as separate compilation mode
  -fgpu-sanitize          Enable sanitizer for AMDGPU target
  -fhip-fp32-correctly-rounded-divide-sqrt
                          Specify that single precision floating-point divide and sqrt used in the program source are correctly rounded (HIP device compilation only)
  -fhip-new-launch-api    Use new kernel launching API for HIP
  -fignore-exceptions     Enable support for ignoring exception handling constructs
  -fimplicit-module-maps  Implicitly search the file system for module map files.
  -finline-functions      Inline suitable functions
  -finline-hint-functions Inline functions which are (explicitly or implicitly) marked inline
  -finput-charset=<value> Specify the default character set for source files
  -finstrument-function-entry-bare
                          Instrument function entry only, after inlining, without arguments to the instrumentation call
  -finstrument-functions-after-inlining
                          Like -finstrument-functions, but insert the calls after inlining
  -finstrument-functions  Generate calls to instrument function entry and exit
  -fintegrated-as         Enable the integrated assembler
  -fintegrated-cc1        Run cc1 in-process
  -fjump-tables           Use jump tables for lowering switches
  -fkeep-static-consts    Keep static const variables if unused
  -flax-vector-conversions=<value>
                          Enable implicit vector bit-casts
  -flegacy-pass-manager   Use the legacy pass manager in LLVM (deprecated, to be removed in a future release)
  -flto-jobs=<value>      Controls the backend parallelism of -flto=thin (default of 0 means the number of threads will be derived from the number of CPUs detected)
  -flto=auto              Enable LTO in \'full\' mode
  -flto=jobserver         Enable LTO in \'full\' mode
  -flto=<value>           Set LTO mode to either \'full\' or \'thin\'
  -flto                   Enable LTO in \'full\' mode
  -fmacro-prefix-map=<value>
                          remap file source paths in predefined preprocessor macros and __builtin_FILE()
  -fmath-errno            Require math functions to indicate errors by setting errno
  -fmax-tokens=<value>    Max total number of preprocessed tokens for -Wmax-tokens.
  -fmax-type-align=<value>
                          Specify the maximum alignment to enforce on pointers lacking an explicit alignment
  -fmemory-profile=<directory>
                          Enable heap memory profiling and dump results into <directory>
  -fmemory-profile        Enable heap memory profiling
  -fmerge-all-constants   Allow merging of constants
  -fmessage-length=<value>
                          Format message diagnostics so that they fit within N columns
  -fminimize-whitespace   Minimize whitespace when emitting preprocessor output
  -fmodule-file=[<name>=]<file>
                          Specify the mapping of module name to precompiled module file, or load a module file if name is omitted.
  -fmodule-map-file=<file>
                          Load this module map file
  -fmodule-name=<name>    Specify the name of the module to build
  -fmodules-cache-path=<directory>
                          Specify the module cache path
  -fmodules-decluse       Require declaration of modules used within a module
  -fmodules-disable-diagnostic-validation
                          Disable validation of the diagnostic options when loading the module
  -fmodules-ignore-macro=<value>
                          Ignore the definition of the given macro when building and loading modules
  -fmodules-prune-after=<seconds>
                          Specify the interval (in seconds) after which a module file will be considered unused
  -fmodules-prune-interval=<seconds>
                          Specify the interval (in seconds) between attempts to prune the module cache
  -fmodules-search-all    Search even non-imported modules to resolve references
  -fmodules-strict-decluse
                          Like -fmodules-decluse but requires all headers to be in modules
  -fmodules-ts            Enable support for the C++ Modules TS
  -fmodules-user-build-path <directory>
                          Specify the module user build path
  -fmodules-validate-input-files-content
                          Validate PCM input files based on content if mtime differs
  -fmodules-validate-once-per-build-session
                          Don\'t verify input files for the modules if the module has been successfully validated or loaded during this build session
  -fmodules-validate-system-headers
                          Validate the system headers that a module depends on when loading the module
  -fmodules               Enable the \'modules\' language feature
  -fms-compatibility-version=<value>
                          Dot-separated value representing the Microsoft compiler version number to report in _MSC_VER (0 = don\'t define it (default))
  -fms-compatibility      Enable full Microsoft Visual C++ compatibility
  -fms-extensions         Accept some non-standard constructs supported by the Microsoft compiler
  -fms-hotpatch           Ensure that all functions can be hotpatched at runtime
  -fmsc-version=<value>   Microsoft compiler version number to report in _MSC_VER (0 = don\'t define it (default))
  -fnew-alignment=<align> Specifies the largest alignment guaranteed by \'::operator new(size_t)\'
  -fnew-infallible        Enable treating throwing global C++ operator new as always returning valid memory (annotates with __attribute__((returns_nonnull)) and throw()). This is detectable in source.
  -fno-aapcs-bitfield-width
                          Do not follow the AAPCS standard requirement stating that volatile bit-field width is dictated by the field container type. (ARM only).
  -fno-access-control     Disable C++ access control
  -fno-addrsig            Don\'t emit an address-significance table
  -fno-assume-sane-operator-new
                          Don\'t assume that C++\'s global operator new can\'t alias any pointer
  -fno-autolink           Disable generation of linker directives for automatic library linking
  -fno-builtin-<value>    Disable implicit builtin knowledge of a specific function
  -fno-builtin            Disable implicit builtin knowledge of functions
  -fno-c++-static-destructors
                          Disable C++ static destructor registration
  -fno-char8_t            Disable C++ builtin type char8_t
  -fno-color-diagnostics  Disable colors in diagnostics
  -fno-common             Compile common globals like normal definitions
  -fno-complete-member-pointers
                          Do not require member pointer base types to be complete if they would be significant under the Microsoft ABI
  -fno-constant-cfstrings Disable creation of CodeFoundation-type constant strings
  -fno-coverage-mapping   Disable code coverage analysis
  -fno-crash-diagnostics  Disable auto-generation of preprocessed source files and a script for reproduction during a clang crash
  -fno-cuda-approx-transcendentals
                          Don\'t use approximate transcendental functions
  -fno-cxx-modules        Disable modules for C++
  -fno-debug-macro        Do not emit macro debug information
  -fno-declspec           Disallow __declspec as a keyword
  -fno-delayed-template-parsing
                          Disable delayed template parsing
  -fno-delete-null-pointer-checks
                          Do not treat usage of null pointers as undefined behavior
  -fno-diagnostics-fixit-info
                          Do not include fixit information in diagnostics
  -fno-digraphs           Disallow alternative token representations \'<:\', \':>\', \'<%\', \'%>\', \'%:\', \'%:%:\'
  -fno-direct-access-external-data
                          Use GOT indirection to reference external data symbols
  -fno-discard-value-names
                          Do not discard value names in LLVM IR
  -fno-dollars-in-identifiers
                          Disallow \'$\' in identifiers
  -fno-double-square-bracket-attributes
                          Disable \'[[]]\' attributes in all C and C++ language modes
  -fno-elide-constructors Disable C++ copy constructor elision
  -fno-elide-type         Do not elide types when printing diagnostics
  -fno-eliminate-unused-debug-types
                          Emit  debug info for defined but unused types
  -fno-exceptions         Disable support for exception handling
  -fno-experimental-relative-c++-abi-vtables
                          Do not use the experimental C++ class ABI for classes with virtual tables
  -fno-fine-grained-bitfield-accesses
                          Use large-integer access for consecutive bitfield runs.
  -fno-finite-loops       Do not assume that any loop is finite.
  -fno-fixed-point        Disable fixed point types
  -fno-force-enable-int128
                          Disable support for int128_t type
  -fno-global-isel        Disables the global instruction selector
  -fno-gnu-inline-asm     Disable GNU style inline asm
  -fno-gpu-allow-device-init
                          Don\'t allow device side init function in HIP (experimental)
  -fno-gpu-defer-diag     Don\'t defer host/device related diagnostic messages for CUDA/HIP
  -fno-hip-fp32-correctly-rounded-divide-sqrt
                          Don\'t specify that single precision floating-point divide and sqrt used in the program source are correctly rounded (HIP device compilation only)
  -fno-hip-new-launch-api Don\'t use new kernel launching API for HIP
  -fno-integrated-as      Disable the integrated assembler
  -fno-integrated-cc1     Spawn a separate process for each cc1
  -fno-jump-tables        Do not use jump tables for lowering switches
  -fno-keep-static-consts Don\'t keep static const variables if unused
  -fno-legacy-pass-manager
                          Use the new pass manager in LLVM
  -fno-lto                Disable LTO mode (default)
  -fno-memory-profile     Disable heap memory profiling
  -fno-merge-all-constants
                          Disallow merging of constants
  -fno-new-infallible     Disable treating throwing global C++ operator new as always returning valid memory (annotates with __attribute__((returns_nonnull)) and throw()). This is detectable in source.
  -fno-objc-infer-related-result-type
                          do not infer Objective-C related result type based on method family
  -fno-offload-lto        Disable LTO mode (default) for offload compilation
  -fno-openmp-extensions  Disable all Clang extensions for OpenMP directives and clauses
  -fno-operator-names     Do not treat C++ operator name keywords as synonyms for operators
  -fno-pch-codegen        Do not generate code for uses of this PCH that assumes an explicit object file will be built for the PCH
  -fno-pch-debuginfo      Do not generate debug info for types in an object file built from this PCH and do not generate them elsewhere
  -fno-plt                Use GOT indirection instead of PLT to make external function calls (x86 only)
  -fno-preserve-as-comments
                          Do not preserve comments in inline assembly
  -fno-profile-generate   Disable generation of profile instrumentation.
  -fno-profile-instr-generate
                          Disable generation of profile instrumentation.
  -fno-profile-instr-use  Disable using instrumentation data for profile-guided optimization
  -fno-pseudo-probe-for-profiling
                          Do not emit pseudo probes for sample profiling
  -fno-register-global-dtors-with-atexit
                          Don\'t use atexit or __cxa_atexit to register global destructors
  -fno-rtlib-add-rpath    Do not add -rpath with architecture-specific resource directory to the linker flags
  -fno-rtti-data          Disable generation of RTTI data
  -fno-rtti               Disable generation of rtti information
  -fno-sanitize-address-outline-instrumentation
                          Use default code inlining logic for the address sanitizer
  -fno-sanitize-address-poison-custom-array-cookie
                          Disable poisoning array cookies when using custom operator new[] in AddressSanitizer
  -fno-sanitize-address-use-after-scope
                          Disable use-after-scope detection in AddressSanitizer
  -fno-sanitize-address-use-odr-indicator
                          Disable ODR indicator globals
  -fno-sanitize-cfi-canonical-jump-tables
                          Do not make the jump table addresses canonical in the symbol table
  -fno-sanitize-cfi-cross-dso
                          Disable control flow integrity (CFI) checks for cross-DSO calls.
  -fno-sanitize-coverage=<value>
                          Disable features of coverage instrumentation for Sanitizers
  -fno-sanitize-hwaddress-experimental-aliasing
                          Disable aliasing mode in HWAddressSanitizer
  -fno-sanitize-ignorelist
                          Don\'t use ignorelist file for sanitizers
  -fno-sanitize-memory-param-retval
                          Disable detection of uninitialized parameters and return values
  -fno-sanitize-memory-track-origins
                          Disable origins tracking in MemorySanitizer
  -fno-sanitize-memory-use-after-dtor
                          Disable use-after-destroy detection in MemorySanitizer
  -fno-sanitize-recover=<value>
                          Disable recovery for specified sanitizers
  -fno-sanitize-stats     Disable sanitizer statistics gathering.
  -fno-sanitize-thread-atomics
                          Disable atomic operations instrumentation in ThreadSanitizer
  -fno-sanitize-thread-func-entry-exit
                          Disable function entry/exit instrumentation in ThreadSanitizer
  -fno-sanitize-thread-memory-access
                          Disable memory access instrumentation in ThreadSanitizer
  -fno-sanitize-trap=<value>
                          Disable trapping for specified sanitizers
  -fno-sanitize-trap      Disable trapping for all sanitizers
  -fno-short-wchar        Force wchar_t to be an unsigned int
  -fno-show-column        Do not include column number on diagnostics
  -fno-show-source-location
                          Do not include source location information with diagnostics
  -fno-signed-char        char is unsigned
  -fno-signed-zeros       Allow optimizations that ignore the sign of floating point zeros
  -fno-spell-checking     Disable spell-checking
  -fno-split-machine-functions
                          Disable late function splitting using profile information (x86 ELF)
  -fno-split-stack        Wouldn\'t use segmented stack
  -fno-stack-clash-protection
                          Disable stack clash protection
  -fno-stack-protector    Disable the use of stack protectors
  -fno-standalone-debug   Limit debug information produced to reduce size of debug binary
  -fno-strict-float-cast-overflow
                          Relax language rules and try to match the behavior of the target\'s native float-to-int conversion instructions
  -fno-strict-return      Don\'t treat control flow paths that fall off the end of a non-void function as unreachable
  -fno-sycl               Disables SYCL kernels compilation for device
  -fno-temp-file          Directly create compilation output files. This may lead to incorrect incremental builds if the compiler crashes
  -fno-threadsafe-statics Do not emit code to make initialization of local statics thread safe
  -fno-trigraphs          Do not process trigraph sequences
  -fno-unique-section-names
                          Don\'t use unique names for text and data sections
  -fno-unroll-loops       Turn off loop unroller
  -fno-use-cxa-atexit     Don\'t use __cxa_atexit for calling destructors
  -fno-use-init-array     Use .ctors/.dtors instead of .init_array/.fini_array
  -fno-visibility-inlines-hidden-static-local-var
                          Disables -fvisibility-inlines-hidden-static-local-var (this is the default on non-darwin targets)
  -fno-xray-function-index
                          Omit function index section at the expense of single-function patching performance
  -fno-zero-initialized-in-bss
                          Don\'t place zero initialized data in BSS
  -fobjc-arc-exceptions   Use EH-safe code when synthesizing retains and releases in -fobjc-arc
  -fobjc-arc              Synthesize retain and release calls for Objective-C pointers
  -fobjc-disable-direct-methods-for-testing
                          Ignore attribute objc_direct so that direct methods can be tested
  -fobjc-encode-cxx-class-template-spec
                          Fully encode c++ class template specialization
  -fobjc-exceptions       Enable Objective-C exceptions
  -fobjc-runtime=<value>  Specify the target Objective-C runtime kind and version
  -fobjc-weak             Enable ARC-style weak references in Objective-C
  -foffload-lto=<value>   Set LTO mode to either \'full\' or \'thin\' for offload compilation
  -foffload-lto           Enable LTO in \'full\' mode for offload compilation
  -fopenmp-extensions     Enable all Clang extensions for OpenMP directives and clauses
  -fopenmp-implicit-rpath Set rpath on OpenMP executables
  -fopenmp-new-driver     Use the new driver for OpenMP offloading.
  -fopenmp-simd           Emit OpenMP code only for SIMD-based constructs.
  -fopenmp-target-debug   Enable debugging in the OpenMP offloading device RTL
  -fopenmp-target-new-runtime
                          Use the new bitcode library for OpenMP offloading
  -fopenmp-targets=<value>
                          Specify comma-separated list of triples OpenMP offloading targets to be supported
  -fopenmp-version=<value>
                          Set OpenMP version (e.g. 45 for OpenMP 4.5, 50 for OpenMP 5.0). Default value is 50.
  -fopenmp                Parse OpenMP pragmas and generate parallel code.
  -foptimization-record-file=<file>
                          Specify the output name of the file containing the optimization remarks. Implies -fsave-optimization-record. On Darwin platforms, this cannot be used with multiple -arch <arch> options.
  -foptimization-record-passes=<regex>
                          Only include passes which match a specified regular expression in the generated optimization record (by default, include all passes)
  -forder-file-instrumentation
                          Generate instrumented code to collect order file into default.profraw file (overridden by \'=\' form of option or LLVM_PROFILE_FILE env var)
  -fpack-struct=<value>   Specify the default maximum struct packing alignment
  -fpascal-strings        Recognize and construct Pascal-style string literals
  -fpass-plugin=<dsopath> Load pass plugin from a dynamic shared object file (only with new pass manager).
  -fpatchable-function-entry=<N,M>
                          Generate M NOPs before function entry and N-M NOPs after function entry
  -fpcc-struct-return     Override the default ABI to return all structs on the stack
  -fpch-codegen           Generate code for uses of this PCH that assumes an explicit object file will be built for the PCH
  -fpch-debuginfo         Generate debug info for types in an object file built from this PCH and do not generate them elsewhere
  -fpch-instantiate-templates
                          Instantiate templates already while building a PCH
  -fpch-validate-input-files-content
                          Validate PCH input files based on content if mtime differs
  -fplugin-arg-<name>-<arg>
                          Pass <arg> to plugin <name>
  -fplugin=<dsopath>      Load the named plugin (dynamic shared object)
  -fprebuilt-implicit-modules
                          Look up implicit modules in the prebuilt module path
  -fprebuilt-module-path=<directory>
                          Specify the prebuilt module path
  -fproc-stat-report=<value>
                          Save subprocess statistics to the given file
  -fproc-stat-report<value>
                          Print subprocess statistics
  -fprofile-exclude-files=<value>
                          Instrument only functions from files where names don\'t match all the regexes separated by a semi-colon
  -fprofile-filter-files=<value>
                          Instrument only functions from files where names match any regex separated by a semi-colon
  -fprofile-generate=<directory>
                          Generate instrumented code to collect execution counts into <directory>/default.profraw (overridden by LLVM_PROFILE_FILE env var)
  -fprofile-generate      Generate instrumented code to collect execution counts into default.profraw (overridden by LLVM_PROFILE_FILE env var)
  -fprofile-instr-generate=<file>
                          Generate instrumented code to collect execution counts into <file> (overridden by LLVM_PROFILE_FILE env var)
  -fprofile-instr-generate
                          Generate instrumented code to collect execution counts into default.profraw file (overridden by \'=\' form of option or LLVM_PROFILE_FILE env var)
  -fprofile-instr-use=<value>
                          Use instrumentation data for profile-guided optimization
  -fprofile-list=<value>  Filename defining the list of functions/files to instrument
  -fprofile-remapping-file=<file>
                          Use the remappings described in <file> to match the profile data against names in the program
  -fprofile-sample-accurate
                          Specifies that the sample profile is accurate
  -fprofile-sample-use=<value>
                          Enable sample-based profile guided optimizations
  -fprofile-update=<method>
                          Set update method of profile counters (atomic,prefer-atomic,single)
  -fprofile-use=<pathname>
                          Use instrumentation data for profile-guided optimization. If pathname is a directory, it reads from <pathname>/default.profdata. Otherwise, it reads from file <pathname>.
  -fprotect-parens        Determines whether the optimizer honors parentheses when floating-point expressions are evaluated
  -fpseudo-probe-for-profiling
                          Emit pseudo probes for sample profiling
  -freciprocal-math       Allow division operations to be reassociated
  -freg-struct-return     Override the default ABI to return small structs in registers
  -fregister-global-dtors-with-atexit
                          Use atexit or __cxa_atexit to register global destructors
  -frelaxed-template-template-args
                          Enable C++17 relaxed template template argument matching
  -freroll-loops          Turn on loop reroller
  -fropi                  Generate read-only position independent code (ARM only)
  -frtlib-add-rpath       Add -rpath with architecture-specific resource directory to the linker flags
  -frwpi                  Generate read-write position independent code (ARM only)
  -fsanitize-address-destructor=<value>
                          Set destructor type used in ASan instrumentation
  -fsanitize-address-field-padding=<value>
                          Level of field padding for AddressSanitizer
  -fsanitize-address-globals-dead-stripping
                          Enable linker dead stripping of globals in AddressSanitizer
  -fsanitize-address-outline-instrumentation
                          Always generate function calls for address sanitizer instrumentation
  -fsanitize-address-poison-custom-array-cookie
                          Enable poisoning array cookies when using custom operator new[] in AddressSanitizer
  -fsanitize-address-use-after-return=<mode>
                          Select the mode of detecting stack use-after-return in AddressSanitizer: never | runtime (default) | always
  -fsanitize-address-use-after-scope
                          Enable use-after-scope detection in AddressSanitizer
  -fsanitize-address-use-odr-indicator
                          Enable ODR indicator globals to avoid false ODR violation reports in partially sanitized programs at the cost of an increase in binary size
  -fsanitize-blacklist=<value>
                          Alias for -fsanitize-ignorelist=
  -fsanitize-cfi-canonical-jump-tables
                          Make the jump table addresses canonical in the symbol table
  -fsanitize-cfi-cross-dso
                          Enable control flow integrity (CFI) checks for cross-DSO calls.
  -fsanitize-cfi-icall-generalize-pointers
                          Generalize pointers in CFI indirect call type signature checks
  -fsanitize-coverage-allowlist=<value>
                          Restrict sanitizer coverage instrumentation exclusively to modules and functions that match the provided special case list, except the blocked ones
  -fsanitize-coverage-blacklist=<value>
                          Deprecated, use -fsanitize-coverage-ignorelist= instead
  -fsanitize-coverage-ignorelist=<value>
                          Disable sanitizer coverage instrumentation for modules and functions that match the provided special case list, even the allowed ones
  -fsanitize-coverage-whitelist=<value>
                          Deprecated, use -fsanitize-coverage-allowlist= instead
  -fsanitize-coverage=<value>
                          Specify the type of coverage instrumentation for Sanitizers
  -fsanitize-hwaddress-abi=<value>
                          Select the HWAddressSanitizer ABI to target (interceptor or platform, default interceptor). This option is currently unused.
  -fsanitize-hwaddress-experimental-aliasing
                          Enable aliasing mode in HWAddressSanitizer
  -fsanitize-ignorelist=<value>
                          Path to ignorelist file for sanitizers
  -fsanitize-memory-param-retval
                          Enable detection of uninitialized parameters and return values
  -fsanitize-memory-track-origins=<value>
                          Enable origins tracking in MemorySanitizer
  -fsanitize-memory-track-origins
                          Enable origins tracking in MemorySanitizer
  -fsanitize-memory-use-after-dtor
                          Enable use-after-destroy detection in MemorySanitizer
  -fsanitize-recover=<value>
                          Enable recovery for specified sanitizers
  -fsanitize-stats        Enable sanitizer statistics gathering.
  -fsanitize-system-blacklist=<value>
                          Alias for -fsanitize-system-ignorelist=
  -fsanitize-system-ignorelist=<value>
                          Path to system ignorelist file for sanitizers
  -fsanitize-thread-atomics
                          Enable atomic operations instrumentation in ThreadSanitizer (default)
  -fsanitize-thread-func-entry-exit
                          Enable function entry/exit instrumentation in ThreadSanitizer (default)
  -fsanitize-thread-memory-access
                          Enable memory access instrumentation in ThreadSanitizer (default)
  -fsanitize-trap=<value> Enable trapping for specified sanitizers
  -fsanitize-trap         Enable trapping for all sanitizers
  -fsanitize-undefined-strip-path-components=<number>
                          Strip (or keep only, if negative) a given number of path components when emitting check metadata.
  -fsanitize=<check>      Turn on runtime checks for various forms of undefined or suspicious behavior. See user manual for available checks
  -fsave-optimization-record=<format>
                          Generate an optimization record file in a specific format
  -fsave-optimization-record
                          Generate a YAML optimization record file
  -fseh-exceptions        Use SEH style exceptions
  -fshort-enums           Allocate to an enum type only as many bytes as it needs for the declared range of possible values
  -fshort-wchar           Force wchar_t to be a short unsigned int
  -fshow-overloads=<value>
                          Which overload candidates to show when overload resolution fails: best|all; defaults to all
  -fshow-skipped-includes Show skipped includes in -H output.
  -fsigned-char           char is signed
  -fsized-deallocation    Enable C++14 sized global deallocation functions
  -fsjlj-exceptions       Use SjLj style exceptions
  -fslp-vectorize         Enable the superword-level parallelism vectorization passes
  -fsplit-dwarf-inlining  Provide minimal debug info in the object/executable to facilitate online symbolication/stack traces in the absence of .dwo/.dwp files when using Split DWARF
  -fsplit-lto-unit        Enables splitting of the LTO unit
  -fsplit-machine-functions
                          Enable late function splitting using profile information (x86 ELF)
  -fsplit-stack           Use segmented stack
  -fstack-clash-protection
                          Enable stack clash protection
  -fstack-protector-all   Enable stack protectors for all functions
  -fstack-protector-strong
                          Enable stack protectors for some functions vulnerable to stack smashing. Compared to -fstack-protector, this uses a stronger heuristic that includes functions containing arrays of any size (and any type), as well as any calls to alloca or the taking of an address from a local variable
  -fstack-protector       Enable stack protectors for some functions vulnerable to stack smashing. This uses a loose heuristic which considers functions vulnerable if they contain a char (or 8bit integer) array or constant sized calls to alloca , which are of greater size than ssp-buffer-size (default: 8 bytes). All variable sized calls to alloca are considered vulnerable. A function with a stack protector has a guard value added to the stack frame that is checked on function exit. The guard value must be positioned in the stack frame such that a buffer overflow from a vulnerable variable will overwrite the guard value before overwriting the function\'s return address. The reference stack guard value is stored in a global variable.
  -fstack-size-section    Emit section containing metadata on function stack sizes
  -fstack-usage           Emit .su file containing information on function stack sizes
  -fstandalone-debug      Emit full debug info for all types used by the program
  -fstrict-enums          Enable optimizations based on the strict definition of an enum\'s value range
  -fstrict-float-cast-overflow
                          Assume that overflowing float-to-int casts are undefined (default)
  -fstrict-vtable-pointers
                          Enable optimizations based on the strict rules for overwriting polymorphic C++ objects
  -fswift-async-fp=<option>
                          Control emission of Swift async extended frame info (option: auto, always, never)
  -fsycl                  Enables SYCL kernels compilation for device
  -fsystem-module         Build this module as a system module. Only used with -emit-module
  -fthin-link-bitcode=<value>
                          Write minimized bitcode to <file> for the ThinLTO thin link only
  -fthinlto-index=<value> Perform ThinLTO importing using provided function summary index
  -ftime-report=<value>   (For new pass manager) "per-pass": one report for each pass; "per-pass-run": one report for each pass invocation
  -ftime-trace-granularity=<value>
                          Minimum time granularity (in microseconds) traced by time profiler
  -ftime-trace            Turn on time profiler. Generates JSON file based on output filename.
  -ftrap-function=<value> Issue call to specified function rather than a trap instruction
  -ftrapv-handler=<function name>
                          Specify the function to be called on overflow
  -ftrapv                 Trap on integer overflow
  -ftrigraphs             Process trigraph sequences
  -ftrivial-auto-var-init-stop-after=<value>
                          Stop initializing trivial automatic stack variables after the specified number of instances
  -ftrivial-auto-var-init=<value>
                          Initialize trivial automatic stack variables: uninitialized (default) | pattern
  -funique-basic-block-section-names
                          Use unique names for basic block sections (ELF Only)
  -funique-internal-linkage-names
                          Uniqueify Internal Linkage Symbol Names by appending the MD5 hash of the module path
  -funroll-loops          Turn on loop unroller
  -fuse-cuid=<value>      Method to generate ID\'s for compilation units for single source offloading languages CUDA and HIP: \'hash\' (ID\'s generated by hashing file path and command line options) | \'random\' (ID\'s generated as random numbers) | \'none\' (disabled). Default is \'hash\'. This option will be overridden by option \'-cuid=[ID]\' if it is specified.
  -fuse-line-directives   Use #line in preprocessed output
  -fvalidate-ast-input-files-content
                          Compute and store the hash of input files used to build an AST. Files with mismatching mtime\'s are considered valid if both contents is identical
  -fveclib=<value>        Use the given vector functions library
  -fvectorize             Enable the loop vectorization passes
  -fverbose-asm           Generate verbose assembly output
  -fvirtual-function-elimination
                          Enables dead virtual function elimination optimization. Requires -flto=full
  -fvisibility-dllexport=<value>
                          The visibility for dllexport definitions [-fvisibility-from-dllstorageclass]
  -fvisibility-externs-dllimport=<value>
                          The visibility for dllimport external declarations [-fvisibility-from-dllstorageclass]
  -fvisibility-externs-nodllstorageclass=<value>
                          The visibility for external declarations without an explicit DLL dllstorageclass [-fvisibility-from-dllstorageclass]
  -fvisibility-from-dllstorageclass
                          Set the visibility of symbols in the generated code from their DLL storage class
  -fvisibility-global-new-delete-hidden
                          Give global C++ operator new and delete declarations hidden visibility
  -fvisibility-inlines-hidden-static-local-var
                          When -fvisibility-inlines-hidden is enabled, static variables in inline C++ member functions will also be given hidden visibility by default
  -fvisibility-inlines-hidden
                          Give inline C++ member functions hidden visibility by default
  -fvisibility-ms-compat  Give global types \'default\' visibility and global functions and variables \'hidden\' visibility by default
  -fvisibility-nodllstorageclass=<value>
                          The visibility for defintiions without an explicit DLL export class [-fvisibility-from-dllstorageclass]
  -fvisibility=<value>    Set the default symbol visibility for all global declarations
  -fwasm-exceptions       Use WebAssembly style exceptions
  -fwhole-program-vtables Enables whole-program vtable optimization. Requires -flto
  -fwrapv                 Treat signed integer overflow as two\'s complement
  -fwritable-strings      Store string literals as writable data
  -fxl-pragma-pack        Enable IBM XL #pragma pack handling
  -fxray-always-emit-customevents
                          Always emit __xray_customevent(...) calls even if the containing function is not always instrumented
  -fxray-always-emit-typedevents
                          Always emit __xray_typedevent(...) calls even if the containing function is not always instrumented
  -fxray-always-instrument= <value>
                          DEPRECATED: Filename defining the whitelist for imbuing the \'always instrument\' XRay attribute.
  -fxray-attr-list= <value>
                          Filename defining the list of functions/types for imbuing XRay attributes.
  -fxray-function-groups=<value>
                          Only instrument 1 of N groups
  -fxray-ignore-loops     Don\'t instrument functions with loops unless they also meet the minimum function size
  -fxray-instruction-threshold= <value>
                          Sets the minimum function size to instrument with XRay
  -fxray-instrumentation-bundle= <value>
                          Select which XRay instrumentation points to emit. Options: all, none, function-entry, function-exit, function, custom. Default is \'all\'.  \'function\' includes both \'function-entry\' and \'function-exit\'.
  -fxray-instrument       Generate XRay instrumentation sleds on function entry and exit
  -fxray-link-deps        Tells clang to add the link dependencies for XRay.
  -fxray-modes= <value>   List of modes to link in by default into XRay instrumented binaries.
  -fxray-never-instrument= <value>
                          DEPRECATED: Filename defining the whitelist for imbuing the \'never instrument\' XRay attribute.
  -fxray-selected-function-group=<value>
                          When using -fxray-function-groups, select which group of functions to instrument. Valid range is 0 to fxray-function-groups - 1
  -fzvector               Enable System z vector language extension
  -F <value>              Add directory to framework include search path
  --gcc-toolchain=<value> Search for GCC installation in the specified directory on targets which commonly use GCC. The directory usually contains \'lib{,32,64}/gcc{,-cross}/$triple\' and \'include\'. If specified, sysroot is skipped for GCC detection. Note: executables (e.g. ld) used by the compiler are not overridden by the selected GCC installation
  -gcodeview-ghash        Emit type record hashes in a .debug$H section
  -gcodeview              Generate CodeView debug information
  -gdwarf-2               Generate source-level debug information with dwarf version 2
  -gdwarf-3               Generate source-level debug information with dwarf version 3
  -gdwarf-4               Generate source-level debug information with dwarf version 4
  -gdwarf-5               Generate source-level debug information with dwarf version 5
  -gdwarf32               Enables DWARF32 format for ELF binaries, if debug information emission is enabled.
  -gdwarf64               Enables DWARF64 format for ELF binaries, if debug information emission is enabled.
  -gdwarf                 Generate source-level debug information with the default dwarf version
  -gembed-source          Embed source text in DWARF debug sections
  -gline-directives-only  Emit debug line info directives only
  -gline-tables-only      Emit debug line number tables only
  -gmodules               Generate debug info with external references to clang modules or precompiled headers
  -gno-embed-source       Restore the default behavior of not embedding source text in DWARF debug sections
  -gno-inline-line-tables Don\'t emit inline line tables.
  --gpu-bundle-output     Bundle output files of HIP device compilation
  --gpu-instrument-lib=<value>
                          Instrument device library for HIP, which is a LLVM bitcode containing __cyg_profile_func_enter and __cyg_profile_func_exit
  --gpu-max-threads-per-block=<value>
                          Default max threads per block for kernel launch bounds for HIP
  -gsplit-dwarf=<value>   Set DWARF fission mode to either \'split\' or \'single\'
  -gz=<value>             DWARF debug sections compression type
  -G <size>               Put objects of at most <size> bytes into small data section (MIPS / Hexagon)
  -g                      Generate source-level debug information
  --help-hidden           Display help for hidden options
  -help                   Display available options
  --hip-device-lib=<value>
                          HIP device library
  --hip-link              Link clang-offload-bundler bundles for HIP
  --hip-path=<value>      HIP runtime installation path, used for finding HIP version and adding HIP include path.
  --hip-version=<value>   HIP version in the format of major.minor.patch
  --hipspv-pass-plugin=<dsopath>
                          path to a pass plugin for HIP to SPIR-V passes.
  -H                      Show header includes and nesting depth
  -I-                     Restrict all prior -I flags to double-quoted inclusion and remove current directory from include path
  -ibuiltininc            Enable builtin #include directories even when -nostdinc is used before or after -ibuiltininc. Using -nobuiltininc after the option disables it
  -idirafter <value>      Add directory to AFTER include search path
  -iframeworkwithsysroot <directory>
                          Add directory to SYSTEM framework search path, absolute paths are relative to -isysroot
  -iframework <value>     Add directory to SYSTEM framework search path
  -imacros <file>         Include macros from file before parsing
  -include-pch <file>     Include precompiled header file
  -include <file>         Include file before parsing
  -index-header-map       Make the next included directory (-I or -F) an indexer header map
  -iprefix <dir>          Set the -iwithprefix/-iwithprefixbefore prefix
  -iquote <directory>     Add directory to QUOTE include search path
  -isysroot <dir>         Set the system root directory (usually /)
  -isystem-after <directory>
                          Add directory to end of the SYSTEM include search path
  -isystem <directory>    Add directory to SYSTEM include search path
  -ivfsoverlay <value>    Overlay the virtual filesystem described by file over the real file system
  -iwithprefixbefore <dir>
                          Set directory to include search path with prefix
  -iwithprefix <dir>      Set directory to SYSTEM include search path with prefix
  -iwithsysroot <directory>
                          Add directory to SYSTEM include search path, absolute paths are relative to -isysroot
  -I <dir>                Add directory to the end of the list of include search paths
  --libomptarget-amdgcn-bc-path=<value>
                          Path to libomptarget-amdgcn bitcode library
  --libomptarget-nvptx-bc-path=<value>
                          Path to libomptarget-nvptx bitcode library
  -L <dir>                Add directory to library search path
  -mabi=vec-default       Enable the default Altivec ABI on AIX (AIX only). Uses only volatile vector registers.
  -mabi=vec-extabi        Enable the extended Altivec ABI on AIX (AIX only). Uses volatile and nonvolatile vector registers
  -mabicalls              Enable SVR4-style position-independent code (Mips only)
  -maix-struct-return     Return all structs in memory (PPC32 only)
  -malign-branch-boundary=<value>
                          Specify the boundary\'s size to align branches
  -malign-branch=<value>  Specify types of branches to align
  -malign-double          Align doubles to two words in structs (x86 only)
  -mamdgpu-ieee           Sets the IEEE bit in the expected default floating point  mode register. Floating point opcodes that support exception flag gathering quiet and propagate signaling NaN inputs per IEEE 754-2008. This option changes the ABI. (AMDGPU only)
  -mbackchain             Link stack frames through backchain on System Z
  -mbranch-protection=<value>
                          Enforce targets of indirect branches and function returns
  -mbranches-within-32B-boundaries
                          Align selected branches (fused, jcc, jmp) within 32-byte boundary
  -mcmodel=medany         Equivalent to -mcmodel=medium, compatible with RISC-V gcc.
  -mcmodel=medlow         Equivalent to -mcmodel=small, compatible with RISC-V gcc.
  -mcmse                  Allow use of CMSE (Armv8-M Security Extensions)
  -mcode-object-v3        Legacy option to specify code object ABI V3 (AMDGPU only)
  -mcode-object-version=<version>
                          Specify code object ABI version. Defaults to 3. (AMDGPU only)
  -mcrc                   Allow use of CRC instructions (ARM/Mips only)
  -mcumode                Specify CU wavefront execution mode (AMDGPU only)
  -mdouble=<value>        Force double to be 32 bits or 64 bits
  -MD                     Write a depfile containing user and system headers
  -meabi <value>          Set EABI type, e.g. 4, 5 or gnu (default depends on triple)
  -membedded-data         Place constants in the .rodata section instead of the .sdata section even if they meet the -G <size> threshold (MIPS)
  -menable-experimental-extensions
                          Enable use of experimental RISC-V extensions.
  -menable-unsafe-fp-math Allow unsafe floating-point math optimizations which may decrease precision
  -mexec-model=<value>    Execution model (WebAssembly only)
  -mexecute-only          Disallow generation of data access to code sections (ARM only)
  -mextern-sdata          Assume that externally defined data is in the small data if it meets the -G <size> threshold (MIPS)
  -mfentry                Insert calls to fentry at function entry (x86/SystemZ only)
  -mfix-cmse-cve-2021-35465
                          Work around VLLDM erratum CVE-2021-35465 (ARM only)
  -mfix-cortex-a53-835769 Workaround Cortex-A53 erratum 835769 (AArch64 only)
  -mfp32                  Use 32-bit floating point registers (MIPS only)
  -mfp64                  Use 64-bit floating point registers (MIPS only)
  -MF <file>              Write depfile output from -MMD, -MD, -MM, or -M to <file>
  -mgeneral-regs-only     Generate code which only uses the general purpose registers (AArch64/x86 only)
  -mglobal-merge          Enable merging of globals
  -mgpopt                 Use GP relative accesses for symbols known to be in a small data section (MIPS)
  -MG                     Add missing headers to depfile
  -mharden-sls=<value>    Select straight-line speculation hardening scope
  -mhvx-ieee-fp           Enable Hexagon HVX IEEE floating-point
  -mhvx-length=<value>    Set Hexagon Vector Length
  -mhvx-qfloat            Enable Hexagon HVX QFloat instructions
  -mhvx=<value>           Enable Hexagon Vector eXtensions
  -mhvx                   Enable Hexagon Vector eXtensions
  -miamcu                 Use Intel MCU ABI
  -mibt-seal              Optimize fcf-protection=branch/full (requires LTO).
  -mignore-xcoff-visibility
                          Not emit the visibility attribute for asm in AIX OS or give all symbols \'unspecified\' visibility in XCOFF object file
  --migrate               Run the migrator
  -mincremental-linker-compatible
                          (integrated-as) Emit an object file which can be used with an incremental linker
  -mindirect-jump=<value> Change indirect jump instructions to inhibit speculation
  -mios-version-min=<value>
                          Set iOS deployment target
  -MJ <value>             Write a compilation database entry per input
  -mllvm <value>          Additional arguments to forward to LLVM\'s option processing
  -mlocal-sdata           Extend the -G behaviour to object local data (MIPS)
  -mlong-calls            Generate branches with extended addressability, usually via indirect jumps.
  -mlong-double-128       Force long double to be 128 bits
  -mlong-double-64        Force long double to be 64 bits
  -mlong-double-80        Force long double to be 80 bits, padded to 128 bits for storage
  -mlvi-cfi               Enable only control-flow mitigations for Load Value Injection (LVI)
  -mlvi-hardening         Enable all mitigations for Load Value Injection (LVI)
  -mmacosx-version-min=<value>
                          Set Mac OS X deployment target
  -mmadd4                 Enable the generation of 4-operand madd.s, madd.d and related instructions.
  -mmark-bti-property     Add .note.gnu.property with BTI to assembly files (AArch64 only)
  -MMD                    Write a depfile containing user headers
  -mmemops                Enable generation of memop instructions
  -mms-bitfields          Set the default structure layout to be compatible with the Microsoft compiler standard
  -mmsa                   Enable MSA ASE (MIPS only)
  -mmt                    Enable MT ASE (MIPS only)
  -MM                     Like -MMD, but also implies -E and writes to stdout by default
  -mno-abicalls           Disable SVR4-style position-independent code (Mips only)
  -mno-bti-at-return-twice
                          Do not add a BTI instruction after a setjmp or other return-twice construct (Arm/AArch64 only)
  -mno-code-object-v3     Legacy option to specify code object ABI V2 (AMDGPU only)
  -mno-crc                Disallow use of CRC instructions (Mips only)
  -mno-cumode             Specify WGP wavefront execution mode (AMDGPU only)
  -mno-embedded-data      Do not place constants in the .rodata section instead of the .sdata if they meet the -G <size> threshold (MIPS)
  -mno-execute-only       Allow generation of data access to code sections (ARM only)
  -mno-extern-sdata       Do not assume that externally defined data is in the small data if it meets the -G <size> threshold (MIPS)
  -mno-fix-cmse-cve-2021-35465
                          Don\'t work around VLLDM erratum CVE-2021-35465 (ARM only)
  -mno-fix-cortex-a53-835769
                          Don\'t workaround Cortex-A53 erratum 835769 (AArch64 only)
  -mno-global-merge       Disable merging of globals
  -mno-gpopt              Do not use GP relative accesses for symbols known to be in a small data section (MIPS)
  -mno-hvx-ieee-fp        Disable Hexagon HVX IEEE floating-point
  -mno-hvx-qfloat         Disable Hexagon HVX QFloat instructions
  -mno-hvx                Disable Hexagon Vector eXtensions
  -mno-implicit-float     Don\'t generate implicit floating point instructions
  -mno-incremental-linker-compatible
                          (integrated-as) Emit an object file which cannot be used with an incremental linker
  -mno-local-sdata        Do not extend the -G behaviour to object local data (MIPS)
  -mno-long-calls         Restore the default behaviour of not generating long calls
  -mno-lvi-cfi            Disable control-flow mitigations for Load Value Injection (LVI)
  -mno-lvi-hardening      Disable mitigations for Load Value Injection (LVI)
  -mno-madd4              Disable the generation of 4-operand madd.s, madd.d and related instructions.
  -mno-memops             Disable generation of memop instructions
  -mno-movt               Disallow use of movt/movw pairs (ARM only)
  -mno-ms-bitfields       Do not set the default structure layout to be compatible with the Microsoft compiler standard
  -mno-msa                Disable MSA ASE (MIPS only)
  -mno-mt                 Disable MT ASE (MIPS only)
  -mno-neg-immediates     Disallow converting instructions with negative immediates to their negation or inversion.
  -mno-nvj                Disable generation of new-value jumps
  -mno-nvs                Disable generation of new-value stores
  -mno-outline-atomics    Don\'t generate local calls to out-of-line atomic operations
  -mno-outline            Disable function outlining (AArch64 only)
  -mno-packets            Disable generation of instruction packets
  -mno-relax              Disable linker relaxation
  -mno-restrict-it        Allow generation of deprecated IT blocks for ARMv8. It is off by default for ARMv8 Thumb mode
  -mno-save-restore       Disable using library calls for save and restore
  -mno-seses              Disable speculative execution side effect suppression (SESES)
  -mno-stack-arg-probe    Disable stack probes which are enabled by default
  -mno-tgsplit            Disable threadgroup split execution mode (AMDGPU only)
  -mno-tls-direct-seg-refs
                          Disable direct TLS access through segment registers
  -mno-unaligned-access   Force all memory accesses to be aligned (AArch32/AArch64 only)
  -mno-wavefrontsize64    Specify wavefront size 32 mode (AMDGPU only)
  -mnocrc                 Disallow use of CRC instructions (ARM only)
  -mnop-mcount            Generate mcount/__fentry__ calls as nops. To activate they need to be patched in.
  -mnvj                   Enable generation of new-value jumps
  -mnvs                   Enable generation of new-value stores
  -module-dependency-dir <value>
                          Directory to dump module dependencies to
  -module-file-info       Provide information about a particular module file
  -momit-leaf-frame-pointer
                          Omit frame pointer setup for leaf functions
  -moutline-atomics       Generate local calls to out-of-line atomic operations
  -moutline               Enable function outlining (AArch64 only)
  -mpacked-stack          Use packed stack layout (SystemZ only).
  -mpackets               Enable generation of instruction packets
  -mpad-max-prefix-size=<value>
                          Specify maximum number of prefixes to use for padding
  -mprefer-vector-width=<value>
                          Specifies preferred vector width for auto-vectorization. Defaults to \'none\' which allows target specific decisions.
  -MP                     Create phony target for each dependency (other than main file)
  -mqdsp6-compat          Enable hexagon-qdsp6 backward compatibility
  -MQ <value>             Specify name of main file output to quote in depfile
  -mrecord-mcount         Generate a __mcount_loc section entry for each __fentry__ call.
  -mrelax-all             (integrated-as) Relax all machine instructions
  -mrelax                 Enable linker relaxation
  -mrestrict-it           Disallow generation of deprecated IT blocks for ARMv8. It is on by default for ARMv8 Thumb mode.
  -mrtd                   Make StdCall calling convention the default
  -msave-restore          Enable using library calls for save and restore
  -mseses                 Enable speculative execution side effect suppression (SESES). Includes LVI control flow integrity mitigations
  -msign-return-address=<value>
                          Select return address signing scope
  -mskip-rax-setup        Skip setting up RAX register when passing variable arguments (x86 only)
  -msmall-data-limit=<value>
                          Put global and static data smaller than the limit into a special section
  -msoft-float            Use software floating point
  -mstack-alignment=<value>
                          Set the stack alignment
  -mstack-arg-probe       Enable stack probes
  -mstack-probe-size=<value>
                          Set the stack probe size
  -mstack-protector-guard-offset=<value>
                          Use the given offset for addressing the stack-protector guard
  -mstack-protector-guard-reg=<value>
                          Use the given reg for addressing the stack-protector guard
  -mstack-protector-guard=<value>
                          Use the given guard (global, tls) for addressing the stack-protector guard
  -mstackrealign          Force realign the stack at entry to every function
  -msve-vector-bits=<value>
                          Specify the size in bits of an SVE vector register. Defaults to the vector length agnostic value of "scalable". (AArch64 only)
  -msvr4-struct-return    Return small structs in registers (PPC32 only)
  -mtargetos=<value>      Set the deployment target to be the specified OS and OS version
  -mtgsplit               Enable threadgroup split execution mode (AMDGPU only)
  -mthread-model <value>  The thread model to use, e.g. posix, single (posix by default)
  -mtls-direct-seg-refs   Enable direct TLS access through segment registers (default)
  -mtls-size=<value>      Specify bit size of immediate TLS offsets (AArch64 ELF only): 12 (for 4KB) | 24 (for 16MB, default) | 32 (for 4GB) | 48 (for 256TB, needs -mcmodel=large)
  -mtp=<value>            Thread pointer access method (AArch32/AArch64 only)
  -mtune=<value>          Only supported on X86 and RISC-V. Otherwise accepted for compatibility with GCC.
  -MT <value>             Specify name of main file output in depfile
  -munaligned-access      Allow memory accesses to be unaligned (AArch32/AArch64 only)
  -munsafe-fp-atomics     Enable unsafe floating point atomic instructions (AMDGPU only)
  -mvscale-max=<value>    Specify the vscale maximum. Defaults to the vector length agnostic value of "0". (AArch64 only)
  -mvscale-min=<value>    Specify the vscale minimum. Defaults to "1". (AArch64 only)
  -MV                     Use NMake/Jom format for the depfile
  -mwavefrontsize64       Specify wavefront size 64 mode (AMDGPU only)
  -M                      Like -MD, but also implies -E and writes to stdout by default
  --no-cuda-include-ptx=<value>
                          Do not include PTX for the following GPU architecture (e.g. sm_35) or \'all\'. May be specified more than once.
  --no-cuda-version-check Don\'t error out if the detected version of the CUDA install is too low for the requested CUDA gpu architecture.
  --no-gpu-bundle-output  Do not bundle output files of HIP device compilation
  --no-offload-arch=<value>
                          Remove CUDA/HIP offloading device architecture (e.g. sm_35, gfx906) from the list of devices to compile for. \'all\' resets the list to its default value.
  --no-system-header-prefix=<prefix>
                          Treat all #include paths starting with <prefix> as not including a system header.
  -nobuiltininc           Disable builtin #include directories
  -nogpuinc               Do not add include paths for CUDA/HIP and do not include the default CUDA/HIP wrapper headers
  -nogpulib               Do not link device library for CUDA/HIP device compilation
  -nohipwrapperinc        Do not include the default HIP wrapper headers and include paths
  -nostdinc++             Disable standard #include directories for the C++ standard library
  -ObjC++                 Treat source input files as Objective-C++ inputs
  -objcmt-allowlist-dir-path=<value>
                          Only modify files with a filename contained in the provided directory path
  -objcmt-atomic-property Make migration to \'atomic\' properties
  -objcmt-migrate-all     Enable migration to modern ObjC
  -objcmt-migrate-annotation
                          Enable migration to property and method annotations
  -objcmt-migrate-designated-init
                          Enable migration to infer NS_DESIGNATED_INITIALIZER for initializer methods
  -objcmt-migrate-instancetype
                          Enable migration to infer instancetype for method result type
  -objcmt-migrate-literals
                          Enable migration to modern ObjC literals
  -objcmt-migrate-ns-macros
                          Enable migration to NS_ENUM/NS_OPTIONS macros
  -objcmt-migrate-property-dot-syntax
                          Enable migration of setter/getter messages to property-dot syntax
  -objcmt-migrate-property
                          Enable migration to modern ObjC property
  -objcmt-migrate-protocol-conformance
                          Enable migration to add protocol conformance on classes
  -objcmt-migrate-readonly-property
                          Enable migration to modern ObjC readonly property
  -objcmt-migrate-readwrite-property
                          Enable migration to modern ObjC readwrite property
  -objcmt-migrate-subscripting
                          Enable migration to modern ObjC subscripting
  -objcmt-ns-nonatomic-iosonly
                          Enable migration to use NS_NONATOMIC_IOSONLY macro for setting property\'s \'atomic\' attribute
  -objcmt-returns-innerpointer-property
                          Enable migration to annotate property with NS_RETURNS_INNER_POINTER
  -objcmt-whitelist-dir-path=<value>
                          Alias for -objcmt-allowlist-dir-path
  -ObjC                   Treat source input files as Objective-C inputs
  -object-file-name=<file>
                          Set the output <file> for debug infos
  --offload-arch=<value>  CUDA offloading device architecture (e.g. sm_35), or HIP offloading target ID in the form of a device architecture followed by target ID features delimited by a colon. Each target ID feature is a pre-defined string followed by a plus or minus sign (e.g. gfx908:xnack+:sramecc-).  May be specified more than once.
  --offload=<value>       Specify comma-separated list of offloading target triples (CUDA and HIP only)
  -o <file>               Write output to <file>
  -pedantic               Warn on language extensions
  -pg                     Enable mcount instrumentation
  -pipe                   Use pipes between commands, when possible
  --precompile            Only precompile the input
  -print-effective-triple Print the effective target triple
  -print-file-name=<file> Print the full library path of <file>
  -print-ivar-layout      Enable Objective-C Ivar layout bitmap print trace
  -print-libgcc-file-name Print the library path for the currently used compiler runtime library ("libgcc.a" or "libclang_rt.builtins.*.a")
  -print-multiarch        Print the multiarch target triple
  -print-prog-name=<name> Print the full program path of <name>
  -print-resource-dir     Print the resource directory pathname
  -print-rocm-search-dirs Print the paths used for finding ROCm installation
  -print-runtime-dir      Print the directory pathname containing clangs runtime libraries
  -print-search-dirs      Print the paths used for finding libraries and programs
  -print-supported-cpus   Print supported cpu models for the given target (if target is not specified, it will print the supported cpus for the default target)
  -print-target-triple    Print the normalized target triple
  -print-targets          Print the registered targets
  -pthread                Support POSIX threads in generated code
  --ptxas-path=<value>    Path to ptxas (used for compiling CUDA code)
  -P                      Disable linemarker output in -E mode
  -Qn                     Do not emit metadata containing compiler name and version
  -Qunused-arguments      Don\'t emit warning for unused driver arguments
  -Qy                     Emit metadata containing compiler name and version
  -relocatable-pch        Whether to build a relocatable precompiled header
  -rewrite-legacy-objc    Rewrite Legacy Objective-C source to C++
  -rewrite-objc           Rewrite Objective-C source to C++
  --rocm-device-lib-path=<value>
                          ROCm device library path. Alternative to rocm-path.
  --rocm-path=<value>     ROCm installation path, used for finding and automatically linking required bitcode libraries.
  -Rpass-analysis=<value> Report transformation analysis from optimization passes whose name matches the given POSIX regular expression
  -Rpass-missed=<value>   Report missed transformations by optimization passes whose name matches the given POSIX regular expression
  -Rpass=<value>          Report transformations performed by optimization passes whose name matches the given POSIX regular expression
  -rtlib=<value>          Compiler runtime library to use
  -R<remark>              Enable the specified remark
  -save-stats=<value>     Save llvm statistics.
  -save-stats             Save llvm statistics.
  -save-temps=<value>     Save intermediate compilation results.
  -save-temps             Save intermediate compilation results
  -serialize-diagnostics <value>
                          Serialize compiler diagnostics to a file
  -shared-libsan          Dynamically link the sanitizer runtime
  --start-no-unused-arguments
                          Don\'t emit warnings about unused arguments for the following arguments
  -static-libsan          Statically link the sanitizer runtime
  -static-openmp          Use the static host OpenMP runtime while linking.
  -std=<value>            Language standard to compile for
  -stdlib++-isystem <directory>
                          Use directory as the C++ standard library include path
  -stdlib=<value>         C++ standard library to use
  -sycl-std=<value>       SYCL language standard to compile for.
  --system-header-prefix=<prefix>
                          Treat all #include paths starting with <prefix> as including a system header.
  -S                      Only run preprocess and compilation steps
  --target=<value>        Generate code for the given target
  -Tbss <addr>            Set starting address of BSS to <addr>
  -Tdata <addr>           Set starting address of DATA to <addr>
  -time                   Time individual commands
  -traditional-cpp        Enable some traditional CPP emulation
  -trigraphs              Process trigraph sequences
  -Ttext <addr>           Set starting address of TEXT to <addr>
  -T <script>             Specify <script> as linker script
  -undef                  undef all system defines
  -unwindlib=<value>      Unwind library to use
  -U <macro>              Undefine macro <macro>
  --verify-debug-info     Verify the binary representation of debug output
  -verify-pch             Load and verify that a pre-compiled header file is not stale
  --version               Print version information
  -v                      Show commands to run and use verbose output
  -Wa,<arg>               Pass the comma separated arguments in <arg> to the assembler
  -Wdeprecated            Enable warnings for deprecated constructs and define __DEPRECATED
  -Wl,<arg>               Pass the comma separated arguments in <arg> to the linker
  -working-directory <value>
                          Resolve file paths relative to the specified directory
  -Wp,<arg>               Pass the comma separated arguments in <arg> to the preprocessor
  -W<warning>             Enable the specified warning
  -w                      Suppress all warnings
  -Xanalyzer <arg>        Pass <arg> to the static analyzer
  -Xarch_device <arg>     Pass <arg> to the CUDA/HIP device compilation
  -Xarch_host <arg>       Pass <arg> to the CUDA/HIP host compilation
  -Xassembler <arg>       Pass <arg> to the assembler
  -Xclang <arg>           Pass <arg> to the clang compiler
  -Xcuda-fatbinary <arg>  Pass <arg> to fatbinary invocation
  -Xcuda-ptxas <arg>      Pass <arg> to the ptxas assembler
  -Xlinker <arg>          Pass <arg> to the linker
  -Xopenmp-target=<triple> <arg>
                          Pass <arg> to the target offloading toolchain identified by <triple>.
  -Xopenmp-target <arg>   Pass <arg> to the target offloading toolchain.
  -Xpreprocessor <arg>    Pass <arg> to the preprocessor
  -x <language>           Treat subsequent input files as having type <language>
  -z <arg>                Pass -z <arg> to the linker

                    
                    ）',
                    "command" => 'clang [options] file...',
                    "examples" => array(),
                ),
                "clang++" => array(
                    "title" => 'clang++ : ',
                    "describe" => '一个C语言、C++、Objective-C语言的轻量级编译器（
                    
OPTIONS:
  -###                    Print (but do not run) the commands to run for this compilation
  --amdgpu-arch-tool=<value>
                          Tool used for detecting AMD GPU arch in the system.
  --analyzer-output <value>
                          Static analyzer report output format (html|plist|plist-multi-file|plist-html|sarif|sarif-html|text).
  --analyze               Run the static analyzer
  -arcmt-migrate-emit-errors
                          Emit ARC errors even if the migrator can fix them
  -arcmt-migrate-report-output <value>
                          Output path for the plist report
  -B <prefix>             Search $prefix$file for executables, libraries, and data files. If $prefix is a directory, search $prefix/$file
  -b <arg>                Pass -b <arg> to the linker on AIX (only).
  -CC                     Include comments from within macros in preprocessed output
  -cl-denorms-are-zero    OpenCL only. Allow denormals to be flushed to zero.
  -cl-fast-relaxed-math   OpenCL only. Sets -cl-finite-math-only and -cl-unsafe-math-optimizations, and defines __FAST_RELAXED_MATH__.
  -cl-finite-math-only    OpenCL only. Allow floating-point optimizations that assume arguments and results are not NaNs or +-Inf.
  -cl-fp32-correctly-rounded-divide-sqrt
                          OpenCL only. Specify that single precision floating-point divide and sqrt used in the program source are correctly rounded.
  -cl-kernel-arg-info     OpenCL only. Generate kernel argument metadata.
  -cl-mad-enable          OpenCL only. Allow use of less precise MAD computations in the generated binary.
  -cl-no-signed-zeros     OpenCL only. Allow use of less precise no signed zeros computations in the generated binary.
  -cl-no-stdinc           OpenCL only. Disables all standard includes containing non-native compiler types and functions.
  -cl-opt-disable         OpenCL only. This option disables all optimizations. By default optimizations are enabled.
  -cl-single-precision-constant
                          OpenCL only. Treat double precision floating-point constant as single precision constant.
  -cl-std=<value>         OpenCL language standard to compile for.
  -cl-strict-aliasing     OpenCL only. This option is added for compatibility with OpenCL 1.0.
  -cl-uniform-work-group-size
                          OpenCL only. Defines that the global work-size be a multiple of the work-group size specified to clEnqueueNDRangeKernel
  -cl-unsafe-math-optimizations
                          OpenCL only. Allow unsafe floating-point optimizations.  Also implies -cl-no-signed-zeros and -cl-mad-enable.
  --config <value>        Specifies configuration file
  --cuda-compile-host-device
                          Compile CUDA code for both host and device (default).  Has no effect on non-CUDA compilations.
  --cuda-device-only      Compile CUDA code for device only
  --cuda-host-only        Compile CUDA code for host only.  Has no effect on non-CUDA compilations.
  --cuda-include-ptx=<value>
                          Include PTX for the following GPU architecture (e.g. sm_35) or \'all\'. May be specified more than once.
  --cuda-noopt-device-debug
                          Enable device-side debug info generation. Disables ptxas optimizations.
  --cuda-path-ignore-env  Ignore environment variables to detect CUDA installation
  --cuda-path=<value>     CUDA installation path
  -cuid=<value>           An ID for compilation unit, which should be the same for the same compilation unit but different for different compilation units. It is used to externalize device-side static variables for single source offloading languages CUDA and HIP so that they can be accessed by the host code of the same compilation unit.
  -cxx-isystem <directory>
                          Add directory to the C++ SYSTEM include search path
  -C                      Include comments in preprocessed output
  -c                      Only run preprocess, compile, and assemble steps
  -dD                     Print macro definitions in -E mode in addition to normal output
  -dependency-dot <value> Filename to write DOT-formatted header dependencies to
  -dependency-file <value>
                          Filename (or -) to write dependency output to
  -dI                     Print include directives in -E mode in addition to normal output
  -dM                     Print macro definitions in -E mode instead of normal output
  -dsym-dir <dir>         Directory to output dSYM\'s (if any) to
  -D <macro>=<value>      Define <macro> to <value> (or 1 if <value> omitted)
  -emit-ast               Emit Clang AST files for source inputs
  -emit-interface-stubs   Generate Interface Stub Files.
  -emit-llvm              Use the LLVM representation for assembler and object files
  -emit-merged-ifs        Generate Interface Stub Files, emit merged text not binary.
  --emit-static-lib       Enable linker job to emit a static library.
  -enable-trivial-auto-var-init-zero-knowing-it-will-be-removed-from-clang
                          Trivial automatic variable initialization to zero is only here for benchmarks, it\'ll eventually be removed, and I\'m OK with that because I\'m only using it to benchmark
  --end-no-unused-arguments
                          Start emitting warnings for unused driver arguments
  -extract-api            Extract API information
  -E                      Only run the preprocessor
  -faapcs-bitfield-load   Follows the AAPCS standard that all volatile bit-field write generates at least one load. (ARM only).
  -faapcs-bitfield-width  Follow the AAPCS standard requirement stating that volatile bit-field width is dictated by the field container type. (ARM only).
  -faddrsig               Emit an address-significance table
  -falign-loops=<N>       N must be a power of two. Align loops to the boundary
  -faligned-allocation    Enable C++17 aligned allocation functions
  -fallow-editor-placeholders
                          Treat editor placeholders as valid source code
  -faltivec-src-compat=<value>
                          Source-level compatibility for Altivec vectors (for PowerPC targets). This includes results of vector comparison (scalar for \'xl\', vector for \'gcc\') as well as behavior when initializing with a scalar (splatting for \'xl\', element zero only for \'gcc\'). For \'mixed\', the compatibility is as \'gcc\' for \'vector bool/vector pixel\' and as \'xl\' for other types. Current default is \'mixed\'.
  -fansi-escape-codes     Use ANSI escape codes for diagnostics
  -fapple-kext            Use Apple\'s kernel extensions ABI
  -fapple-link-rtlib      Force linking the clang builtins runtime library
  -fapple-pragma-pack     Enable Apple gcc-compatible #pragma pack handling
  -fapplication-extension Restrict code to those available for App Extensions
  -fapprox-func           Allow certain math function calls to be replaced with an approximately equivalent calculation
  -fasync-exceptions      Enable EH Asynchronous exceptions
  -fbasic-block-sections=<value>
                          Place each function\'s basic blocks in unique sections (ELF Only) : all | labels | none | list=<file>
  -fbinutils-version=<major.minor>
                          Produced object files can use all ELF features supported by this binutils version and newer. If -fno-integrated-as is specified, the generated assembly will consider GNU as support. \'none\' means that all ELF features can be used, regardless of binutils support. Defaults to 2.26.
  -fblocks                Enable the \'blocks\' language feature
  -fborland-extensions    Accept non-standard constructs supported by the Borland compiler
  -fbuild-session-file=<file>
                          Use the last modification time of <file> as the build session timestamp
  -fbuild-session-timestamp=<time since Epoch in seconds>
                          Time when the current build session started
  -fbuiltin-module-map    Load the clang builtins module map file.
  -fc++-abi=<value>       C++ ABI to use. This will override the target C++ ABI.
  -fcall-saved-x10        Make the x10 register call-saved (AArch64 only)
  -fcall-saved-x11        Make the x11 register call-saved (AArch64 only)
  -fcall-saved-x12        Make the x12 register call-saved (AArch64 only)
  -fcall-saved-x13        Make the x13 register call-saved (AArch64 only)
  -fcall-saved-x14        Make the x14 register call-saved (AArch64 only)
  -fcall-saved-x15        Make the x15 register call-saved (AArch64 only)
  -fcall-saved-x18        Make the x18 register call-saved (AArch64 only)
  -fcall-saved-x8         Make the x8 register call-saved (AArch64 only)
  -fcall-saved-x9         Make the x9 register call-saved (AArch64 only)
  -fcf-protection=<value> Instrument control-flow architecture protection. Options: return, branch, full, none.
  -fcf-protection         Enable cf-protection in \'full\' mode
  -fchar8_t               Enable C++ builtin type char8_t
  -fclang-abi-compat=<version>
                          Attempt to match the ABI of Clang <version>
  -fcolor-diagnostics     Enable colors in diagnostics
  -fcomment-block-commands=<arg>
                          Treat each comma separated argument in <arg> as a documentation comment block command
  -fcommon                Place uninitialized global variables in a common block
  -fcomplete-member-pointers
                          Require member pointer base types to be complete if they would be significant under the Microsoft ABI
  -fconvergent-functions  Assume functions may be convergent
  -fcoroutines-ts         Enable support for the C++ Coroutines TS
  -fcoverage-compilation-dir=<value>
                          The compilation directory to embed in the coverage mapping.
  -fcoverage-mapping      Generate coverage mapping to enable code coverage analysis
  -fcoverage-prefix-map=<value>
                          remap file source paths in coverage mapping
  -fcrash-diagnostics-dir=<dir>
                          Put crash-report files in <dir>
  -fcs-profile-generate=<directory>
                          Generate instrumented code to collect context sensitive execution counts into <directory>/default.profraw (overridden by LLVM_PROFILE_FILE env var)
  -fcs-profile-generate   Generate instrumented code to collect context sensitive execution counts into default.profraw (overridden by LLVM_PROFILE_FILE env var)
  -fcuda-approx-transcendentals
                          Use approximate transcendental functions
  -fcuda-short-ptr        Use 32-bit pointers for accessing const/local/shared address spaces
  -fcxx-exceptions        Enable C++ exceptions
  -fcxx-modules           Enable modules for C++
  -fdata-sections         Place each data in its own section
  -fdebug-compilation-dir=<value>
                          The compilation directory to embed in the debug info
  -fdebug-default-version=<value>
                          Default DWARF version to use, if a -g option caused DWARF debug info to be produced
  -fdebug-info-for-profiling
                          Emit extra debug info to make sample profile more accurate
  -fdebug-macro           Emit macro debug information
  -fdebug-prefix-map=<value>
                          remap file source paths in debug info
  -fdebug-ranges-base-address
                          Use DWARF base address selection entries in .debug_ranges
  -fdebug-types-section   Place debug types in their own section (ELF Only)
  -fdeclspec              Allow __declspec as a keyword
  -fdelayed-template-parsing
                          Parse templated function definitions at the end of the translation unit
  -fdelete-null-pointer-checks
                          Treat usage of null pointers as undefined behavior (default)
  -fdiagnostics-absolute-paths
                          Print absolute paths in diagnostics
  -fdiagnostics-hotness-threshold=<value>
                          Prevent optimization remarks from being output if they do not have at least this profile count. Use \'auto\' to apply the threshold from profile summary
  -fdiagnostics-parseable-fixits
                          Print fix-its in machine parseable form
  -fdiagnostics-print-source-range-info
                          Print source range spans in numeric form
  -fdiagnostics-show-hotness
                          Enable profile hotness information in diagnostic line
  -fdiagnostics-show-note-include-stack
                          Display include stacks for diagnostic notes
  -fdiagnostics-show-option
                          Print option name with mappable diagnostics
  -fdiagnostics-show-template-tree
                          Print a template comparison tree for differing templates
  -fdigraphs              Enable alternative token representations \'<:\', \':>\', \'<%\', \'%>\', \'%:\', \'%:%:\' (default)
  -fdirect-access-external-data
                          Don\'t use GOT indirection to reference external data symbols
  -fdiscard-value-names   Discard value names in LLVM IR
  -fdollars-in-identifiers
                          Allow \'$\' in identifiers
  -fdouble-square-bracket-attributes
                          Enable \'[[]]\' attributes in all C and C++ language modes
  -fdwarf-exceptions      Use DWARF style exceptions
  -feliminate-unused-debug-types
                          Do not emit  debug info for defined but unused types
  -fembed-bitcode-marker  Embed placeholder LLVM IR data as a marker
  -fembed-bitcode=<option>
                          Embed LLVM bitcode (option: off, all, bitcode, marker)
  -fembed-bitcode         Embed LLVM IR bitcode as data
  -fembed-offload-object=<value>
                          Embed Offloading device-side binary into host object file as a section.
  -femit-all-decls        Emit all declarations, even if unused
  -femulated-tls          Use emutls functions to access thread_local variables
  -fenable-matrix         Enable matrix data type and related builtin functions
  -fexceptions            Enable support for exception handling
  -fexperimental-new-constant-interpreter
                          Enable the experimental new constant interpreter
  -fexperimental-relative-c++-abi-vtables
                          Use the experimental C++ class ABI for classes with virtual tables
  -fexperimental-strict-floating-point
                          Enables experimental strict floating point in LLVM.
  -fextend-arguments=<value>
                          Controls how scalar integer arguments are extended in calls to unprototyped and varargs functions
  -ffast-math             Allow aggressive, lossy floating-point optimizations
  -ffile-compilation-dir=<value>
                          The compilation directory to embed in the debug info and coverage mapping.
  -ffile-prefix-map=<value>
                          remap file source paths in debug info, predefined preprocessor macros and __builtin_FILE()
  -ffine-grained-bitfield-accesses
                          Use separate accesses for consecutive bitfield runs with legal widths and alignments.
  -ffinite-loops          Assume all loops are finite.
  -ffixed-a0              Reserve the a0 register (M68k only)
  -ffixed-a1              Reserve the a1 register (M68k only)
  -ffixed-a2              Reserve the a2 register (M68k only)
  -ffixed-a3              Reserve the a3 register (M68k only)
  -ffixed-a4              Reserve the a4 register (M68k only)
  -ffixed-a5              Reserve the a5 register (M68k only)
  -ffixed-a6              Reserve the a6 register (M68k only)
  -ffixed-d0              Reserve the d0 register (M68k only)
  -ffixed-d1              Reserve the d1 register (M68k only)
  -ffixed-d2              Reserve the d2 register (M68k only)
  -ffixed-d3              Reserve the d3 register (M68k only)
  -ffixed-d4              Reserve the d4 register (M68k only)
  -ffixed-d5              Reserve the d5 register (M68k only)
  -ffixed-d6              Reserve the d6 register (M68k only)
  -ffixed-d7              Reserve the d7 register (M68k only)
  -ffixed-point           Enable fixed point types
  -ffixed-r19             Reserve register r19 (Hexagon only)
  -ffixed-r9              Reserve the r9 register (ARM only)
  -ffixed-x10             Reserve the x10 register (AArch64/RISC-V only)
  -ffixed-x11             Reserve the x11 register (AArch64/RISC-V only)
  -ffixed-x12             Reserve the x12 register (AArch64/RISC-V only)
  -ffixed-x13             Reserve the x13 register (AArch64/RISC-V only)
  -ffixed-x14             Reserve the x14 register (AArch64/RISC-V only)
  -ffixed-x15             Reserve the x15 register (AArch64/RISC-V only)
  -ffixed-x16             Reserve the x16 register (AArch64/RISC-V only)
  -ffixed-x17             Reserve the x17 register (AArch64/RISC-V only)
  -ffixed-x18             Reserve the x18 register (AArch64/RISC-V only)
  -ffixed-x19             Reserve the x19 register (AArch64/RISC-V only)
  -ffixed-x1              Reserve the x1 register (AArch64/RISC-V only)
  -ffixed-x20             Reserve the x20 register (AArch64/RISC-V only)
  -ffixed-x21             Reserve the x21 register (AArch64/RISC-V only)
  -ffixed-x22             Reserve the x22 register (AArch64/RISC-V only)
  -ffixed-x23             Reserve the x23 register (AArch64/RISC-V only)
  -ffixed-x24             Reserve the x24 register (AArch64/RISC-V only)
  -ffixed-x25             Reserve the x25 register (AArch64/RISC-V only)
  -ffixed-x26             Reserve the x26 register (AArch64/RISC-V only)
  -ffixed-x27             Reserve the x27 register (AArch64/RISC-V only)
  -ffixed-x28             Reserve the x28 register (AArch64/RISC-V only)
  -ffixed-x29             Reserve the x29 register (AArch64/RISC-V only)
  -ffixed-x2              Reserve the x2 register (AArch64/RISC-V only)
  -ffixed-x30             Reserve the x30 register (AArch64/RISC-V only)
  -ffixed-x31             Reserve the x31 register (AArch64/RISC-V only)
  -ffixed-x3              Reserve the x3 register (AArch64/RISC-V only)
  -ffixed-x4              Reserve the x4 register (AArch64/RISC-V only)
  -ffixed-x5              Reserve the x5 register (AArch64/RISC-V only)
  -ffixed-x6              Reserve the x6 register (AArch64/RISC-V only)
  -ffixed-x7              Reserve the x7 register (AArch64/RISC-V only)
  -ffixed-x8              Reserve the x8 register (AArch64/RISC-V only)
  -ffixed-x9              Reserve the x9 register (AArch64/RISC-V only)
  -fforce-dwarf-frame     Always emit a debug frame section
  -fforce-emit-vtables    Emits more virtual tables to improve devirtualization
  -fforce-enable-int128   Enable support for int128_t type
  -ffp-contract=<value>   Form fused FP ops (e.g. FMAs): fast (fuses across statements disregarding pragmas) | on (only fuses in the same statement unless dictated by pragmas) | off (never fuses) | fast-honor-pragmas (fuses across statements unless diectated by pragmas). Default is \'fast\' for CUDA, \'fast-honor-pragmas\' for HIP, and \'on\' otherwise.
  -ffp-exception-behavior=<value>
                          Specifies the exception behavior of floating-point operations.
  -ffp-model=<value>      Controls the semantics of floating-point calculations.
  -ffreestanding          Assert that the compilation takes place in a freestanding environment
  -ffuchsia-api-level=<value>
                          Set Fuchsia API level
  -ffunction-sections     Place each function in its own section
  -fglobal-isel           Enables the global instruction selector
  -fgnu-keywords          Allow GNU-extension keywords regardless of language standard
  -fgnu-runtime           Generate output compatible with the standard GNU Objective-C runtime
  -fgnu89-inline          Use the gnu89 inline semantics
  -fgnuc-version=<value>  Sets various macros to claim compatibility with the given GCC version (default is 4.2.1)
  -fgpu-allow-device-init Allow device side init function in HIP (experimental)
  -fgpu-defer-diag        Defer host/device related diagnostic messages for CUDA/HIP
  -fgpu-flush-denormals-to-zero
                          Flush denormal floating point values to zero in CUDA/HIP device mode.
  -fgpu-rdc               Generate relocatable device code, also known as separate compilation mode
  -fgpu-sanitize          Enable sanitizer for AMDGPU target
  -fhip-fp32-correctly-rounded-divide-sqrt
                          Specify that single precision floating-point divide and sqrt used in the program source are correctly rounded (HIP device compilation only)
  -fhip-new-launch-api    Use new kernel launching API for HIP
  -fignore-exceptions     Enable support for ignoring exception handling constructs
  -fimplicit-module-maps  Implicitly search the file system for module map files.
  -finline-functions      Inline suitable functions
  -finline-hint-functions Inline functions which are (explicitly or implicitly) marked inline
  -finput-charset=<value> Specify the default character set for source files
  -finstrument-function-entry-bare
                          Instrument function entry only, after inlining, without arguments to the instrumentation call
  -finstrument-functions-after-inlining
                          Like -finstrument-functions, but insert the calls after inlining
  -finstrument-functions  Generate calls to instrument function entry and exit
  -fintegrated-as         Enable the integrated assembler
  -fintegrated-cc1        Run cc1 in-process
  -fjump-tables           Use jump tables for lowering switches
  -fkeep-static-consts    Keep static const variables if unused
  -flax-vector-conversions=<value>
                          Enable implicit vector bit-casts
  -flegacy-pass-manager   Use the legacy pass manager in LLVM (deprecated, to be removed in a future release)
  -flto-jobs=<value>      Controls the backend parallelism of -flto=thin (default of 0 means the number of threads will be derived from the number of CPUs detected)
  -flto=auto              Enable LTO in \'full\' mode
  -flto=jobserver         Enable LTO in \'full\' mode
  -flto=<value>           Set LTO mode to either \'full\' or \'thin\'
  -flto                   Enable LTO in \'full\' mode
  -fmacro-prefix-map=<value>
                          remap file source paths in predefined preprocessor macros and __builtin_FILE()
  -fmath-errno            Require math functions to indicate errors by setting errno
  -fmax-tokens=<value>    Max total number of preprocessed tokens for -Wmax-tokens.
  -fmax-type-align=<value>
                          Specify the maximum alignment to enforce on pointers lacking an explicit alignment
  -fmemory-profile=<directory>
                          Enable heap memory profiling and dump results into <directory>
  -fmemory-profile        Enable heap memory profiling
  -fmerge-all-constants   Allow merging of constants
  -fmessage-length=<value>
                          Format message diagnostics so that they fit within N columns
  -fminimize-whitespace   Minimize whitespace when emitting preprocessor output
  -fmodule-file=[<name>=]<file>
                          Specify the mapping of module name to precompiled module file, or load a module file if name is omitted.
  -fmodule-map-file=<file>
                          Load this module map file
  -fmodule-name=<name>    Specify the name of the module to build
  -fmodules-cache-path=<directory>
                          Specify the module cache path
  -fmodules-decluse       Require declaration of modules used within a module
  -fmodules-disable-diagnostic-validation
                          Disable validation of the diagnostic options when loading the module
  -fmodules-ignore-macro=<value>
                          Ignore the definition of the given macro when building and loading modules
  -fmodules-prune-after=<seconds>
                          Specify the interval (in seconds) after which a module file will be considered unused
  -fmodules-prune-interval=<seconds>
                          Specify the interval (in seconds) between attempts to prune the module cache
  -fmodules-search-all    Search even non-imported modules to resolve references
  -fmodules-strict-decluse
                          Like -fmodules-decluse but requires all headers to be in modules
  -fmodules-ts            Enable support for the C++ Modules TS
  -fmodules-user-build-path <directory>
                          Specify the module user build path
  -fmodules-validate-input-files-content
                          Validate PCM input files based on content if mtime differs
  -fmodules-validate-once-per-build-session
                          Don\'t verify input files for the modules if the module has been successfully validated or loaded during this build session
  -fmodules-validate-system-headers
                          Validate the system headers that a module depends on when loading the module
  -fmodules               Enable the \'modules\' language feature
  -fms-compatibility-version=<value>
                          Dot-separated value representing the Microsoft compiler version number to report in _MSC_VER (0 = don\'t define it (default))
  -fms-compatibility      Enable full Microsoft Visual C++ compatibility
  -fms-extensions         Accept some non-standard constructs supported by the Microsoft compiler
  -fms-hotpatch           Ensure that all functions can be hotpatched at runtime
  -fmsc-version=<value>   Microsoft compiler version number to report in _MSC_VER (0 = don\'t define it (default))
  -fnew-alignment=<align> Specifies the largest alignment guaranteed by \'::operator new(size_t)\'
  -fnew-infallible        Enable treating throwing global C++ operator new as always returning valid memory (annotates with __attribute__((returns_nonnull)) and throw()). This is detectable in source.
  -fno-aapcs-bitfield-width
                          Do not follow the AAPCS standard requirement stating that volatile bit-field width is dictated by the field container type. (ARM only).
  -fno-access-control     Disable C++ access control
  -fno-addrsig            Don\'t emit an address-significance table
  -fno-assume-sane-operator-new
                          Don\'t assume that C++\'s global operator new can\'t alias any pointer
  -fno-autolink           Disable generation of linker directives for automatic library linking
  -fno-builtin-<value>    Disable implicit builtin knowledge of a specific function
  -fno-builtin            Disable implicit builtin knowledge of functions
  -fno-c++-static-destructors
                          Disable C++ static destructor registration
  -fno-char8_t            Disable C++ builtin type char8_t
  -fno-color-diagnostics  Disable colors in diagnostics
  -fno-common             Compile common globals like normal definitions
  -fno-complete-member-pointers
                          Do not require member pointer base types to be complete if they would be significant under the Microsoft ABI
  -fno-constant-cfstrings Disable creation of CodeFoundation-type constant strings
  -fno-coverage-mapping   Disable code coverage analysis
  -fno-crash-diagnostics  Disable auto-generation of preprocessed source files and a script for reproduction during a clang crash
  -fno-cuda-approx-transcendentals
                          Don\'t use approximate transcendental functions
  -fno-cxx-modules        Disable modules for C++
  -fno-debug-macro        Do not emit macro debug information
  -fno-declspec           Disallow __declspec as a keyword
  -fno-delayed-template-parsing
                          Disable delayed template parsing
  -fno-delete-null-pointer-checks
                          Do not treat usage of null pointers as undefined behavior
  -fno-diagnostics-fixit-info
                          Do not include fixit information in diagnostics
  -fno-digraphs           Disallow alternative token representations \'<:\', \':>\', \'<%\', \'%>\', \'%:\', \'%:%:\'
  -fno-direct-access-external-data
                          Use GOT indirection to reference external data symbols
  -fno-discard-value-names
                          Do not discard value names in LLVM IR
  -fno-dollars-in-identifiers
                          Disallow \'$\' in identifiers
  -fno-double-square-bracket-attributes
                          Disable \'[[]]\' attributes in all C and C++ language modes
  -fno-elide-constructors Disable C++ copy constructor elision
  -fno-elide-type         Do not elide types when printing diagnostics
  -fno-eliminate-unused-debug-types
                          Emit  debug info for defined but unused types
  -fno-exceptions         Disable support for exception handling
  -fno-experimental-relative-c++-abi-vtables
                          Do not use the experimental C++ class ABI for classes with virtual tables
  -fno-fine-grained-bitfield-accesses
                          Use large-integer access for consecutive bitfield runs.
  -fno-finite-loops       Do not assume that any loop is finite.
  -fno-fixed-point        Disable fixed point types
  -fno-force-enable-int128
                          Disable support for int128_t type
  -fno-global-isel        Disables the global instruction selector
  -fno-gnu-inline-asm     Disable GNU style inline asm
  -fno-gpu-allow-device-init
                          Don\'t allow device side init function in HIP (experimental)
  -fno-gpu-defer-diag     Don\'t defer host/device related diagnostic messages for CUDA/HIP
  -fno-hip-fp32-correctly-rounded-divide-sqrt
                          Don\'t specify that single precision floating-point divide and sqrt used in the program source are correctly rounded (HIP device compilation only)
  -fno-hip-new-launch-api Don\'t use new kernel launching API for HIP
  -fno-integrated-as      Disable the integrated assembler
  -fno-integrated-cc1     Spawn a separate process for each cc1
  -fno-jump-tables        Do not use jump tables for lowering switches
  -fno-keep-static-consts Don\'t keep static const variables if unused
  -fno-legacy-pass-manager
                          Use the new pass manager in LLVM
  -fno-lto                Disable LTO mode (default)
  -fno-memory-profile     Disable heap memory profiling
  -fno-merge-all-constants
                          Disallow merging of constants
  -fno-new-infallible     Disable treating throwing global C++ operator new as always returning valid memory (annotates with __attribute__((returns_nonnull)) and throw()). This is detectable in source.
  -fno-objc-infer-related-result-type
                          do not infer Objective-C related result type based on method family
  -fno-offload-lto        Disable LTO mode (default) for offload compilation
  -fno-openmp-extensions  Disable all Clang extensions for OpenMP directives and clauses
  -fno-operator-names     Do not treat C++ operator name keywords as synonyms for operators
  -fno-pch-codegen        Do not generate code for uses of this PCH that assumes an explicit object file will be built for the PCH
  -fno-pch-debuginfo      Do not generate debug info for types in an object file built from this PCH and do not generate them elsewhere
  -fno-plt                Use GOT indirection instead of PLT to make external function calls (x86 only)
  -fno-preserve-as-comments
                          Do not preserve comments in inline assembly
  -fno-profile-generate   Disable generation of profile instrumentation.
  -fno-profile-instr-generate
                          Disable generation of profile instrumentation.
  -fno-profile-instr-use  Disable using instrumentation data for profile-guided optimization
  -fno-pseudo-probe-for-profiling
                          Do not emit pseudo probes for sample profiling
  -fno-register-global-dtors-with-atexit
                          Don\'t use atexit or __cxa_atexit to register global destructors
  -fno-rtlib-add-rpath    Do not add -rpath with architecture-specific resource directory to the linker flags
  -fno-rtti-data          Disable generation of RTTI data
  -fno-rtti               Disable generation of rtti information
  -fno-sanitize-address-outline-instrumentation
                          Use default code inlining logic for the address sanitizer
  -fno-sanitize-address-poison-custom-array-cookie
                          Disable poisoning array cookies when using custom operator new[] in AddressSanitizer
  -fno-sanitize-address-use-after-scope
                          Disable use-after-scope detection in AddressSanitizer
  -fno-sanitize-address-use-odr-indicator
                          Disable ODR indicator globals
  -fno-sanitize-cfi-canonical-jump-tables
                          Do not make the jump table addresses canonical in the symbol table
  -fno-sanitize-cfi-cross-dso
                          Disable control flow integrity (CFI) checks for cross-DSO calls.
  -fno-sanitize-coverage=<value>
                          Disable features of coverage instrumentation for Sanitizers
  -fno-sanitize-hwaddress-experimental-aliasing
                          Disable aliasing mode in HWAddressSanitizer
  -fno-sanitize-ignorelist
                          Don\'t use ignorelist file for sanitizers
  -fno-sanitize-memory-param-retval
                          Disable detection of uninitialized parameters and return values
  -fno-sanitize-memory-track-origins
                          Disable origins tracking in MemorySanitizer
  -fno-sanitize-memory-use-after-dtor
                          Disable use-after-destroy detection in MemorySanitizer
  -fno-sanitize-recover=<value>
                          Disable recovery for specified sanitizers
  -fno-sanitize-stats     Disable sanitizer statistics gathering.
  -fno-sanitize-thread-atomics
                          Disable atomic operations instrumentation in ThreadSanitizer
  -fno-sanitize-thread-func-entry-exit
                          Disable function entry/exit instrumentation in ThreadSanitizer
  -fno-sanitize-thread-memory-access
                          Disable memory access instrumentation in ThreadSanitizer
  -fno-sanitize-trap=<value>
                          Disable trapping for specified sanitizers
  -fno-sanitize-trap      Disable trapping for all sanitizers
  -fno-short-wchar        Force wchar_t to be an unsigned int
  -fno-show-column        Do not include column number on diagnostics
  -fno-show-source-location
                          Do not include source location information with diagnostics
  -fno-signed-char        char is unsigned
  -fno-signed-zeros       Allow optimizations that ignore the sign of floating point zeros
  -fno-spell-checking     Disable spell-checking
  -fno-split-machine-functions
                          Disable late function splitting using profile information (x86 ELF)
  -fno-split-stack        Wouldn\'t use segmented stack
  -fno-stack-clash-protection
                          Disable stack clash protection
  -fno-stack-protector    Disable the use of stack protectors
  -fno-standalone-debug   Limit debug information produced to reduce size of debug binary
  -fno-strict-float-cast-overflow
                          Relax language rules and try to match the behavior of the target\'s native float-to-int conversion instructions
  -fno-strict-return      Don\'t treat control flow paths that fall off the end of a non-void function as unreachable
  -fno-sycl               Disables SYCL kernels compilation for device
  -fno-temp-file          Directly create compilation output files. This may lead to incorrect incremental builds if the compiler crashes
  -fno-threadsafe-statics Do not emit code to make initialization of local statics thread safe
  -fno-trigraphs          Do not process trigraph sequences
  -fno-unique-section-names
                          Don\'t use unique names for text and data sections
  -fno-unroll-loops       Turn off loop unroller
  -fno-use-cxa-atexit     Don\'t use __cxa_atexit for calling destructors
  -fno-use-init-array     Use .ctors/.dtors instead of .init_array/.fini_array
  -fno-visibility-inlines-hidden-static-local-var
                          Disables -fvisibility-inlines-hidden-static-local-var (this is the default on non-darwin targets)
  -fno-xray-function-index
                          Omit function index section at the expense of single-function patching performance
  -fno-zero-initialized-in-bss
                          Don\'t place zero initialized data in BSS
  -fobjc-arc-exceptions   Use EH-safe code when synthesizing retains and releases in -fobjc-arc
  -fobjc-arc              Synthesize retain and release calls for Objective-C pointers
  -fobjc-disable-direct-methods-for-testing
                          Ignore attribute objc_direct so that direct methods can be tested
  -fobjc-encode-cxx-class-template-spec
                          Fully encode c++ class template specialization
  -fobjc-exceptions       Enable Objective-C exceptions
  -fobjc-runtime=<value>  Specify the target Objective-C runtime kind and version
  -fobjc-weak             Enable ARC-style weak references in Objective-C
  -foffload-lto=<value>   Set LTO mode to either \'full\' or \'thin\' for offload compilation
  -foffload-lto           Enable LTO in \'full\' mode for offload compilation
  -fopenmp-extensions     Enable all Clang extensions for OpenMP directives and clauses
  -fopenmp-implicit-rpath Set rpath on OpenMP executables
  -fopenmp-new-driver     Use the new driver for OpenMP offloading.
  -fopenmp-simd           Emit OpenMP code only for SIMD-based constructs.
  -fopenmp-target-debug   Enable debugging in the OpenMP offloading device RTL
  -fopenmp-target-new-runtime
                          Use the new bitcode library for OpenMP offloading
  -fopenmp-targets=<value>
                          Specify comma-separated list of triples OpenMP offloading targets to be supported
  -fopenmp-version=<value>
                          Set OpenMP version (e.g. 45 for OpenMP 4.5, 50 for OpenMP 5.0). Default value is 50.
  -fopenmp                Parse OpenMP pragmas and generate parallel code.
  -foptimization-record-file=<file>
                          Specify the output name of the file containing the optimization remarks. Implies -fsave-optimization-record. On Darwin platforms, this cannot be used with multiple -arch <arch> options.
  -foptimization-record-passes=<regex>
                          Only include passes which match a specified regular expression in the generated optimization record (by default, include all passes)
  -forder-file-instrumentation
                          Generate instrumented code to collect order file into default.profraw file (overridden by \'=\' form of option or LLVM_PROFILE_FILE env var)
  -fpack-struct=<value>   Specify the default maximum struct packing alignment
  -fpascal-strings        Recognize and construct Pascal-style string literals
  -fpass-plugin=<dsopath> Load pass plugin from a dynamic shared object file (only with new pass manager).
  -fpatchable-function-entry=<N,M>
                          Generate M NOPs before function entry and N-M NOPs after function entry
  -fpcc-struct-return     Override the default ABI to return all structs on the stack
  -fpch-codegen           Generate code for uses of this PCH that assumes an explicit object file will be built for the PCH
  -fpch-debuginfo         Generate debug info for types in an object file built from this PCH and do not generate them elsewhere
  -fpch-instantiate-templates
                          Instantiate templates already while building a PCH
  -fpch-validate-input-files-content
                          Validate PCH input files based on content if mtime differs
  -fplugin-arg-<name>-<arg>
                          Pass <arg> to plugin <name>
  -fplugin=<dsopath>      Load the named plugin (dynamic shared object)
  -fprebuilt-implicit-modules
                          Look up implicit modules in the prebuilt module path
  -fprebuilt-module-path=<directory>
                          Specify the prebuilt module path
  -fproc-stat-report=<value>
                          Save subprocess statistics to the given file
  -fproc-stat-report<value>
                          Print subprocess statistics
  -fprofile-exclude-files=<value>
                          Instrument only functions from files where names don\'t match all the regexes separated by a semi-colon
  -fprofile-filter-files=<value>
                          Instrument only functions from files where names match any regex separated by a semi-colon
  -fprofile-generate=<directory>
                          Generate instrumented code to collect execution counts into <directory>/default.profraw (overridden by LLVM_PROFILE_FILE env var)
  -fprofile-generate      Generate instrumented code to collect execution counts into default.profraw (overridden by LLVM_PROFILE_FILE env var)
  -fprofile-instr-generate=<file>
                          Generate instrumented code to collect execution counts into <file> (overridden by LLVM_PROFILE_FILE env var)
  -fprofile-instr-generate
                          Generate instrumented code to collect execution counts into default.profraw file (overridden by \'=\' form of option or LLVM_PROFILE_FILE env var)
  -fprofile-instr-use=<value>
                          Use instrumentation data for profile-guided optimization
  -fprofile-list=<value>  Filename defining the list of functions/files to instrument
  -fprofile-remapping-file=<file>
                          Use the remappings described in <file> to match the profile data against names in the program
  -fprofile-sample-accurate
                          Specifies that the sample profile is accurate
  -fprofile-sample-use=<value>
                          Enable sample-based profile guided optimizations
  -fprofile-update=<method>
                          Set update method of profile counters (atomic,prefer-atomic,single)
  -fprofile-use=<pathname>
                          Use instrumentation data for profile-guided optimization. If pathname is a directory, it reads from <pathname>/default.profdata. Otherwise, it reads from file <pathname>.
  -fprotect-parens        Determines whether the optimizer honors parentheses when floating-point expressions are evaluated
  -fpseudo-probe-for-profiling
                          Emit pseudo probes for sample profiling
  -freciprocal-math       Allow division operations to be reassociated
  -freg-struct-return     Override the default ABI to return small structs in registers
  -fregister-global-dtors-with-atexit
                          Use atexit or __cxa_atexit to register global destructors
  -frelaxed-template-template-args
                          Enable C++17 relaxed template template argument matching
  -freroll-loops          Turn on loop reroller
  -fropi                  Generate read-only position independent code (ARM only)
  -frtlib-add-rpath       Add -rpath with architecture-specific resource directory to the linker flags
  -frwpi                  Generate read-write position independent code (ARM only)
  -fsanitize-address-destructor=<value>
                          Set destructor type used in ASan instrumentation
  -fsanitize-address-field-padding=<value>
                          Level of field padding for AddressSanitizer
  -fsanitize-address-globals-dead-stripping
                          Enable linker dead stripping of globals in AddressSanitizer
  -fsanitize-address-outline-instrumentation
                          Always generate function calls for address sanitizer instrumentation
  -fsanitize-address-poison-custom-array-cookie
                          Enable poisoning array cookies when using custom operator new[] in AddressSanitizer
  -fsanitize-address-use-after-return=<mode>
                          Select the mode of detecting stack use-after-return in AddressSanitizer: never | runtime (default) | always
  -fsanitize-address-use-after-scope
                          Enable use-after-scope detection in AddressSanitizer
  -fsanitize-address-use-odr-indicator
                          Enable ODR indicator globals to avoid false ODR violation reports in partially sanitized programs at the cost of an increase in binary size
  -fsanitize-blacklist=<value>
                          Alias for -fsanitize-ignorelist=
  -fsanitize-cfi-canonical-jump-tables
                          Make the jump table addresses canonical in the symbol table
  -fsanitize-cfi-cross-dso
                          Enable control flow integrity (CFI) checks for cross-DSO calls.
  -fsanitize-cfi-icall-generalize-pointers
                          Generalize pointers in CFI indirect call type signature checks
  -fsanitize-coverage-allowlist=<value>
                          Restrict sanitizer coverage instrumentation exclusively to modules and functions that match the provided special case list, except the blocked ones
  -fsanitize-coverage-blacklist=<value>
                          Deprecated, use -fsanitize-coverage-ignorelist= instead
  -fsanitize-coverage-ignorelist=<value>
                          Disable sanitizer coverage instrumentation for modules and functions that match the provided special case list, even the allowed ones
  -fsanitize-coverage-whitelist=<value>
                          Deprecated, use -fsanitize-coverage-allowlist= instead
  -fsanitize-coverage=<value>
                          Specify the type of coverage instrumentation for Sanitizers
  -fsanitize-hwaddress-abi=<value>
                          Select the HWAddressSanitizer ABI to target (interceptor or platform, default interceptor). This option is currently unused.
  -fsanitize-hwaddress-experimental-aliasing
                          Enable aliasing mode in HWAddressSanitizer
  -fsanitize-ignorelist=<value>
                          Path to ignorelist file for sanitizers
  -fsanitize-memory-param-retval
                          Enable detection of uninitialized parameters and return values
  -fsanitize-memory-track-origins=<value>
                          Enable origins tracking in MemorySanitizer
  -fsanitize-memory-track-origins
                          Enable origins tracking in MemorySanitizer
  -fsanitize-memory-use-after-dtor
                          Enable use-after-destroy detection in MemorySanitizer
  -fsanitize-recover=<value>
                          Enable recovery for specified sanitizers
  -fsanitize-stats        Enable sanitizer statistics gathering.
  -fsanitize-system-blacklist=<value>
                          Alias for -fsanitize-system-ignorelist=
  -fsanitize-system-ignorelist=<value>
                          Path to system ignorelist file for sanitizers
  -fsanitize-thread-atomics
                          Enable atomic operations instrumentation in ThreadSanitizer (default)
  -fsanitize-thread-func-entry-exit
                          Enable function entry/exit instrumentation in ThreadSanitizer (default)
  -fsanitize-thread-memory-access
                          Enable memory access instrumentation in ThreadSanitizer (default)
  -fsanitize-trap=<value> Enable trapping for specified sanitizers
  -fsanitize-trap         Enable trapping for all sanitizers
  -fsanitize-undefined-strip-path-components=<number>
                          Strip (or keep only, if negative) a given number of path components when emitting check metadata.
  -fsanitize=<check>      Turn on runtime checks for various forms of undefined or suspicious behavior. See user manual for available checks
  -fsave-optimization-record=<format>
                          Generate an optimization record file in a specific format
  -fsave-optimization-record
                          Generate a YAML optimization record file
  -fseh-exceptions        Use SEH style exceptions
  -fshort-enums           Allocate to an enum type only as many bytes as it needs for the declared range of possible values
  -fshort-wchar           Force wchar_t to be a short unsigned int
  -fshow-overloads=<value>
                          Which overload candidates to show when overload resolution fails: best|all; defaults to all
  -fshow-skipped-includes Show skipped includes in -H output.
  -fsigned-char           char is signed
  -fsized-deallocation    Enable C++14 sized global deallocation functions
  -fsjlj-exceptions       Use SjLj style exceptions
  -fslp-vectorize         Enable the superword-level parallelism vectorization passes
  -fsplit-dwarf-inlining  Provide minimal debug info in the object/executable to facilitate online symbolication/stack traces in the absence of .dwo/.dwp files when using Split DWARF
  -fsplit-lto-unit        Enables splitting of the LTO unit
  -fsplit-machine-functions
                          Enable late function splitting using profile information (x86 ELF)
  -fsplit-stack           Use segmented stack
  -fstack-clash-protection
                          Enable stack clash protection
  -fstack-protector-all   Enable stack protectors for all functions
  -fstack-protector-strong
                          Enable stack protectors for some functions vulnerable to stack smashing. Compared to -fstack-protector, this uses a stronger heuristic that includes functions containing arrays of any size (and any type), as well as any calls to alloca or the taking of an address from a local variable
  -fstack-protector       Enable stack protectors for some functions vulnerable to stack smashing. This uses a loose heuristic which considers functions vulnerable if they contain a char (or 8bit integer) array or constant sized calls to alloca , which are of greater size than ssp-buffer-size (default: 8 bytes). All variable sized calls to alloca are considered vulnerable. A function with a stack protector has a guard value added to the stack frame that is checked on function exit. The guard value must be positioned in the stack frame such that a buffer overflow from a vulnerable variable will overwrite the guard value before overwriting the function\'s return address. The reference stack guard value is stored in a global variable.
  -fstack-size-section    Emit section containing metadata on function stack sizes
  -fstack-usage           Emit .su file containing information on function stack sizes
  -fstandalone-debug      Emit full debug info for all types used by the program
  -fstrict-enums          Enable optimizations based on the strict definition of an enum\'s value range
  -fstrict-float-cast-overflow
                          Assume that overflowing float-to-int casts are undefined (default)
  -fstrict-vtable-pointers
                          Enable optimizations based on the strict rules for overwriting polymorphic C++ objects
  -fswift-async-fp=<option>
                          Control emission of Swift async extended frame info (option: auto, always, never)
  -fsycl                  Enables SYCL kernels compilation for device
  -fsystem-module         Build this module as a system module. Only used with -emit-module
  -fthin-link-bitcode=<value>
                          Write minimized bitcode to <file> for the ThinLTO thin link only
  -fthinlto-index=<value> Perform ThinLTO importing using provided function summary index
  -ftime-report=<value>   (For new pass manager) "per-pass": one report for each pass; "per-pass-run": one report for each pass invocation
  -ftime-trace-granularity=<value>
                          Minimum time granularity (in microseconds) traced by time profiler
  -ftime-trace            Turn on time profiler. Generates JSON file based on output filename.
  -ftrap-function=<value> Issue call to specified function rather than a trap instruction
  -ftrapv-handler=<function name>
                          Specify the function to be called on overflow
  -ftrapv                 Trap on integer overflow
  -ftrigraphs             Process trigraph sequences
  -ftrivial-auto-var-init-stop-after=<value>
                          Stop initializing trivial automatic stack variables after the specified number of instances
  -ftrivial-auto-var-init=<value>
                          Initialize trivial automatic stack variables: uninitialized (default) | pattern
  -funique-basic-block-section-names
                          Use unique names for basic block sections (ELF Only)
  -funique-internal-linkage-names
                          Uniqueify Internal Linkage Symbol Names by appending the MD5 hash of the module path
  -funroll-loops          Turn on loop unroller
  -fuse-cuid=<value>      Method to generate ID\'s for compilation units for single source offloading languages CUDA and HIP: \'hash\' (ID\'s generated by hashing file path and command line options) | \'random\' (ID\'s generated as random numbers) | \'none\' (disabled). Default is \'hash\'. This option will be overridden by option \'-cuid=[ID]\' if it is specified.
  -fuse-line-directives   Use #line in preprocessed output
  -fvalidate-ast-input-files-content
                          Compute and store the hash of input files used to build an AST. Files with mismatching mtime\'s are considered valid if both contents is identical
  -fveclib=<value>        Use the given vector functions library
  -fvectorize             Enable the loop vectorization passes
  -fverbose-asm           Generate verbose assembly output
  -fvirtual-function-elimination
                          Enables dead virtual function elimination optimization. Requires -flto=full
  -fvisibility-dllexport=<value>
                          The visibility for dllexport definitions [-fvisibility-from-dllstorageclass]
  -fvisibility-externs-dllimport=<value>
                          The visibility for dllimport external declarations [-fvisibility-from-dllstorageclass]
  -fvisibility-externs-nodllstorageclass=<value>
                          The visibility for external declarations without an explicit DLL dllstorageclass [-fvisibility-from-dllstorageclass]
  -fvisibility-from-dllstorageclass
                          Set the visibility of symbols in the generated code from their DLL storage class
  -fvisibility-global-new-delete-hidden
                          Give global C++ operator new and delete declarations hidden visibility
  -fvisibility-inlines-hidden-static-local-var
                          When -fvisibility-inlines-hidden is enabled, static variables in inline C++ member functions will also be given hidden visibility by default
  -fvisibility-inlines-hidden
                          Give inline C++ member functions hidden visibility by default
  -fvisibility-ms-compat  Give global types \'default\' visibility and global functions and variables \'hidden\' visibility by default
  -fvisibility-nodllstorageclass=<value>
                          The visibility for defintiions without an explicit DLL export class [-fvisibility-from-dllstorageclass]
  -fvisibility=<value>    Set the default symbol visibility for all global declarations
  -fwasm-exceptions       Use WebAssembly style exceptions
  -fwhole-program-vtables Enables whole-program vtable optimization. Requires -flto
  -fwrapv                 Treat signed integer overflow as two\'s complement
  -fwritable-strings      Store string literals as writable data
  -fxl-pragma-pack        Enable IBM XL #pragma pack handling
  -fxray-always-emit-customevents
                          Always emit __xray_customevent(...) calls even if the containing function is not always instrumented
  -fxray-always-emit-typedevents
                          Always emit __xray_typedevent(...) calls even if the containing function is not always instrumented
  -fxray-always-instrument= <value>
                          DEPRECATED: Filename defining the whitelist for imbuing the \'always instrument\' XRay attribute.
  -fxray-attr-list= <value>
                          Filename defining the list of functions/types for imbuing XRay attributes.
  -fxray-function-groups=<value>
                          Only instrument 1 of N groups
  -fxray-ignore-loops     Don\'t instrument functions with loops unless they also meet the minimum function size
  -fxray-instruction-threshold= <value>
                          Sets the minimum function size to instrument with XRay
  -fxray-instrumentation-bundle= <value>
                          Select which XRay instrumentation points to emit. Options: all, none, function-entry, function-exit, function, custom. Default is \'all\'.  \'function\' includes both \'function-entry\' and \'function-exit\'.
  -fxray-instrument       Generate XRay instrumentation sleds on function entry and exit
  -fxray-link-deps        Tells clang to add the link dependencies for XRay.
  -fxray-modes= <value>   List of modes to link in by default into XRay instrumented binaries.
  -fxray-never-instrument= <value>
                          DEPRECATED: Filename defining the whitelist for imbuing the \'never instrument\' XRay attribute.
  -fxray-selected-function-group=<value>
                          When using -fxray-function-groups, select which group of functions to instrument. Valid range is 0 to fxray-function-groups - 1
  -fzvector               Enable System z vector language extension
  -F <value>              Add directory to framework include search path
  --gcc-toolchain=<value> Search for GCC installation in the specified directory on targets which commonly use GCC. The directory usually contains \'lib{,32,64}/gcc{,-cross}/$triple\' and \'include\'. If specified, sysroot is skipped for GCC detection. Note: executables (e.g. ld) used by the compiler are not overridden by the selected GCC installation
  -gcodeview-ghash        Emit type record hashes in a .debug$H section
  -gcodeview              Generate CodeView debug information
  -gdwarf-2               Generate source-level debug information with dwarf version 2
  -gdwarf-3               Generate source-level debug information with dwarf version 3
  -gdwarf-4               Generate source-level debug information with dwarf version 4
  -gdwarf-5               Generate source-level debug information with dwarf version 5
  -gdwarf32               Enables DWARF32 format for ELF binaries, if debug information emission is enabled.
  -gdwarf64               Enables DWARF64 format for ELF binaries, if debug information emission is enabled.
  -gdwarf                 Generate source-level debug information with the default dwarf version
  -gembed-source          Embed source text in DWARF debug sections
  -gline-directives-only  Emit debug line info directives only
  -gline-tables-only      Emit debug line number tables only
  -gmodules               Generate debug info with external references to clang modules or precompiled headers
  -gno-embed-source       Restore the default behavior of not embedding source text in DWARF debug sections
  -gno-inline-line-tables Don\'t emit inline line tables.
  --gpu-bundle-output     Bundle output files of HIP device compilation
  --gpu-instrument-lib=<value>
                          Instrument device library for HIP, which is a LLVM bitcode containing __cyg_profile_func_enter and __cyg_profile_func_exit
  --gpu-max-threads-per-block=<value>
                          Default max threads per block for kernel launch bounds for HIP
  -gsplit-dwarf=<value>   Set DWARF fission mode to either \'split\' or \'single\'
  -gz=<value>             DWARF debug sections compression type
  -G <size>               Put objects of at most <size> bytes into small data section (MIPS / Hexagon)
  -g                      Generate source-level debug information
  --help-hidden           Display help for hidden options
  -help                   Display available options
  --hip-device-lib=<value>
                          HIP device library
  --hip-link              Link clang-offload-bundler bundles for HIP
  --hip-path=<value>      HIP runtime installation path, used for finding HIP version and adding HIP include path.
  --hip-version=<value>   HIP version in the format of major.minor.patch
  --hipspv-pass-plugin=<dsopath>
                          path to a pass plugin for HIP to SPIR-V passes.
  -H                      Show header includes and nesting depth
  -I-                     Restrict all prior -I flags to double-quoted inclusion and remove current directory from include path
  -ibuiltininc            Enable builtin #include directories even when -nostdinc is used before or after -ibuiltininc. Using -nobuiltininc after the option disables it
  -idirafter <value>      Add directory to AFTER include search path
  -iframeworkwithsysroot <directory>
                          Add directory to SYSTEM framework search path, absolute paths are relative to -isysroot
  -iframework <value>     Add directory to SYSTEM framework search path
  -imacros <file>         Include macros from file before parsing
  -include-pch <file>     Include precompiled header file
  -include <file>         Include file before parsing
  -index-header-map       Make the next included directory (-I or -F) an indexer header map
  -iprefix <dir>          Set the -iwithprefix/-iwithprefixbefore prefix
  -iquote <directory>     Add directory to QUOTE include search path
  -isysroot <dir>         Set the system root directory (usually /)
  -isystem-after <directory>
                          Add directory to end of the SYSTEM include search path
  -isystem <directory>    Add directory to SYSTEM include search path
  -ivfsoverlay <value>    Overlay the virtual filesystem described by file over the real file system
  -iwithprefixbefore <dir>
                          Set directory to include search path with prefix
  -iwithprefix <dir>      Set directory to SYSTEM include search path with prefix
  -iwithsysroot <directory>
                          Add directory to SYSTEM include search path, absolute paths are relative to -isysroot
  -I <dir>                Add directory to the end of the list of include search paths
  --libomptarget-amdgcn-bc-path=<value>
                          Path to libomptarget-amdgcn bitcode library
  --libomptarget-nvptx-bc-path=<value>
                          Path to libomptarget-nvptx bitcode library
  -L <dir>                Add directory to library search path
  -mabi=vec-default       Enable the default Altivec ABI on AIX (AIX only). Uses only volatile vector registers.
  -mabi=vec-extabi        Enable the extended Altivec ABI on AIX (AIX only). Uses volatile and nonvolatile vector registers
  -mabicalls              Enable SVR4-style position-independent code (Mips only)
  -maix-struct-return     Return all structs in memory (PPC32 only)
  -malign-branch-boundary=<value>
                          Specify the boundary\'s size to align branches
  -malign-branch=<value>  Specify types of branches to align
  -malign-double          Align doubles to two words in structs (x86 only)
  -mamdgpu-ieee           Sets the IEEE bit in the expected default floating point  mode register. Floating point opcodes that support exception flag gathering quiet and propagate signaling NaN inputs per IEEE 754-2008. This option changes the ABI. (AMDGPU only)
  -mbackchain             Link stack frames through backchain on System Z
  -mbranch-protection=<value>
                          Enforce targets of indirect branches and function returns
  -mbranches-within-32B-boundaries
                          Align selected branches (fused, jcc, jmp) within 32-byte boundary
  -mcmodel=medany         Equivalent to -mcmodel=medium, compatible with RISC-V gcc.
  -mcmodel=medlow         Equivalent to -mcmodel=small, compatible with RISC-V gcc.
  -mcmse                  Allow use of CMSE (Armv8-M Security Extensions)
  -mcode-object-v3        Legacy option to specify code object ABI V3 (AMDGPU only)
  -mcode-object-version=<version>
                          Specify code object ABI version. Defaults to 3. (AMDGPU only)
  -mcrc                   Allow use of CRC instructions (ARM/Mips only)
  -mcumode                Specify CU wavefront execution mode (AMDGPU only)
  -mdouble=<value>        Force double to be 32 bits or 64 bits
  -MD                     Write a depfile containing user and system headers
  -meabi <value>          Set EABI type, e.g. 4, 5 or gnu (default depends on triple)
  -membedded-data         Place constants in the .rodata section instead of the .sdata section even if they meet the -G <size> threshold (MIPS)
  -menable-experimental-extensions
                          Enable use of experimental RISC-V extensions.
  -menable-unsafe-fp-math Allow unsafe floating-point math optimizations which may decrease precision
  -mexec-model=<value>    Execution model (WebAssembly only)
  -mexecute-only          Disallow generation of data access to code sections (ARM only)
  -mextern-sdata          Assume that externally defined data is in the small data if it meets the -G <size> threshold (MIPS)
  -mfentry                Insert calls to fentry at function entry (x86/SystemZ only)
  -mfix-cmse-cve-2021-35465
                          Work around VLLDM erratum CVE-2021-35465 (ARM only)
  -mfix-cortex-a53-835769 Workaround Cortex-A53 erratum 835769 (AArch64 only)
  -mfp32                  Use 32-bit floating point registers (MIPS only)
  -mfp64                  Use 64-bit floating point registers (MIPS only)
  -MF <file>              Write depfile output from -MMD, -MD, -MM, or -M to <file>
  -mgeneral-regs-only     Generate code which only uses the general purpose registers (AArch64/x86 only)
  -mglobal-merge          Enable merging of globals
  -mgpopt                 Use GP relative accesses for symbols known to be in a small data section (MIPS)
  -MG                     Add missing headers to depfile
  -mharden-sls=<value>    Select straight-line speculation hardening scope
  -mhvx-ieee-fp           Enable Hexagon HVX IEEE floating-point
  -mhvx-length=<value>    Set Hexagon Vector Length
  -mhvx-qfloat            Enable Hexagon HVX QFloat instructions
  -mhvx=<value>           Enable Hexagon Vector eXtensions
  -mhvx                   Enable Hexagon Vector eXtensions
  -miamcu                 Use Intel MCU ABI
  -mibt-seal              Optimize fcf-protection=branch/full (requires LTO).
  -mignore-xcoff-visibility
                          Not emit the visibility attribute for asm in AIX OS or give all symbols \'unspecified\' visibility in XCOFF object file
  --migrate               Run the migrator
  -mincremental-linker-compatible
                          (integrated-as) Emit an object file which can be used with an incremental linker
  -mindirect-jump=<value> Change indirect jump instructions to inhibit speculation
  -mios-version-min=<value>
                          Set iOS deployment target
  -MJ <value>             Write a compilation database entry per input
  -mllvm <value>          Additional arguments to forward to LLVM\'s option processing
  -mlocal-sdata           Extend the -G behaviour to object local data (MIPS)
  -mlong-calls            Generate branches with extended addressability, usually via indirect jumps.
  -mlong-double-128       Force long double to be 128 bits
  -mlong-double-64        Force long double to be 64 bits
  -mlong-double-80        Force long double to be 80 bits, padded to 128 bits for storage
  -mlvi-cfi               Enable only control-flow mitigations for Load Value Injection (LVI)
  -mlvi-hardening         Enable all mitigations for Load Value Injection (LVI)
  -mmacosx-version-min=<value>
                          Set Mac OS X deployment target
  -mmadd4                 Enable the generation of 4-operand madd.s, madd.d and related instructions.
  -mmark-bti-property     Add .note.gnu.property with BTI to assembly files (AArch64 only)
  -MMD                    Write a depfile containing user headers
  -mmemops                Enable generation of memop instructions
  -mms-bitfields          Set the default structure layout to be compatible with the Microsoft compiler standard
  -mmsa                   Enable MSA ASE (MIPS only)
  -mmt                    Enable MT ASE (MIPS only)
  -MM                     Like -MMD, but also implies -E and writes to stdout by default
  -mno-abicalls           Disable SVR4-style position-independent code (Mips only)
  -mno-bti-at-return-twice
                          Do not add a BTI instruction after a setjmp or other return-twice construct (Arm/AArch64 only)
  -mno-code-object-v3     Legacy option to specify code object ABI V2 (AMDGPU only)
  -mno-crc                Disallow use of CRC instructions (Mips only)
  -mno-cumode             Specify WGP wavefront execution mode (AMDGPU only)
  -mno-embedded-data      Do not place constants in the .rodata section instead of the .sdata if they meet the -G <size> threshold (MIPS)
  -mno-execute-only       Allow generation of data access to code sections (ARM only)
  -mno-extern-sdata       Do not assume that externally defined data is in the small data if it meets the -G <size> threshold (MIPS)
  -mno-fix-cmse-cve-2021-35465
                          Don\'t work around VLLDM erratum CVE-2021-35465 (ARM only)
  -mno-fix-cortex-a53-835769
                          Don\'t workaround Cortex-A53 erratum 835769 (AArch64 only)
  -mno-global-merge       Disable merging of globals
  -mno-gpopt              Do not use GP relative accesses for symbols known to be in a small data section (MIPS)
  -mno-hvx-ieee-fp        Disable Hexagon HVX IEEE floating-point
  -mno-hvx-qfloat         Disable Hexagon HVX QFloat instructions
  -mno-hvx                Disable Hexagon Vector eXtensions
  -mno-implicit-float     Don\'t generate implicit floating point instructions
  -mno-incremental-linker-compatible
                          (integrated-as) Emit an object file which cannot be used with an incremental linker
  -mno-local-sdata        Do not extend the -G behaviour to object local data (MIPS)
  -mno-long-calls         Restore the default behaviour of not generating long calls
  -mno-lvi-cfi            Disable control-flow mitigations for Load Value Injection (LVI)
  -mno-lvi-hardening      Disable mitigations for Load Value Injection (LVI)
  -mno-madd4              Disable the generation of 4-operand madd.s, madd.d and related instructions.
  -mno-memops             Disable generation of memop instructions
  -mno-movt               Disallow use of movt/movw pairs (ARM only)
  -mno-ms-bitfields       Do not set the default structure layout to be compatible with the Microsoft compiler standard
  -mno-msa                Disable MSA ASE (MIPS only)
  -mno-mt                 Disable MT ASE (MIPS only)
  -mno-neg-immediates     Disallow converting instructions with negative immediates to their negation or inversion.
  -mno-nvj                Disable generation of new-value jumps
  -mno-nvs                Disable generation of new-value stores
  -mno-outline-atomics    Don\'t generate local calls to out-of-line atomic operations
  -mno-outline            Disable function outlining (AArch64 only)
  -mno-packets            Disable generation of instruction packets
  -mno-relax              Disable linker relaxation
  -mno-restrict-it        Allow generation of deprecated IT blocks for ARMv8. It is off by default for ARMv8 Thumb mode
  -mno-save-restore       Disable using library calls for save and restore
  -mno-seses              Disable speculative execution side effect suppression (SESES)
  -mno-stack-arg-probe    Disable stack probes which are enabled by default
  -mno-tgsplit            Disable threadgroup split execution mode (AMDGPU only)
  -mno-tls-direct-seg-refs
                          Disable direct TLS access through segment registers
  -mno-unaligned-access   Force all memory accesses to be aligned (AArch32/AArch64 only)
  -mno-wavefrontsize64    Specify wavefront size 32 mode (AMDGPU only)
  -mnocrc                 Disallow use of CRC instructions (ARM only)
  -mnop-mcount            Generate mcount/__fentry__ calls as nops. To activate they need to be patched in.
  -mnvj                   Enable generation of new-value jumps
  -mnvs                   Enable generation of new-value stores
  -module-dependency-dir <value>
                          Directory to dump module dependencies to
  -module-file-info       Provide information about a particular module file
  -momit-leaf-frame-pointer
                          Omit frame pointer setup for leaf functions
  -moutline-atomics       Generate local calls to out-of-line atomic operations
  -moutline               Enable function outlining (AArch64 only)
  -mpacked-stack          Use packed stack layout (SystemZ only).
  -mpackets               Enable generation of instruction packets
  -mpad-max-prefix-size=<value>
                          Specify maximum number of prefixes to use for padding
  -mprefer-vector-width=<value>
                          Specifies preferred vector width for auto-vectorization. Defaults to \'none\' which allows target specific decisions.
  -MP                     Create phony target for each dependency (other than main file)
  -mqdsp6-compat          Enable hexagon-qdsp6 backward compatibility
  -MQ <value>             Specify name of main file output to quote in depfile
  -mrecord-mcount         Generate a __mcount_loc section entry for each __fentry__ call.
  -mrelax-all             (integrated-as) Relax all machine instructions
  -mrelax                 Enable linker relaxation
  -mrestrict-it           Disallow generation of deprecated IT blocks for ARMv8. It is on by default for ARMv8 Thumb mode.
  -mrtd                   Make StdCall calling convention the default
  -msave-restore          Enable using library calls for save and restore
  -mseses                 Enable speculative execution side effect suppression (SESES). Includes LVI control flow integrity mitigations
  -msign-return-address=<value>
                          Select return address signing scope
  -mskip-rax-setup        Skip setting up RAX register when passing variable arguments (x86 only)
  -msmall-data-limit=<value>
                          Put global and static data smaller than the limit into a special section
  -msoft-float            Use software floating point
  -mstack-alignment=<value>
                          Set the stack alignment
  -mstack-arg-probe       Enable stack probes
  -mstack-probe-size=<value>
                          Set the stack probe size
  -mstack-protector-guard-offset=<value>
                          Use the given offset for addressing the stack-protector guard
  -mstack-protector-guard-reg=<value>
                          Use the given reg for addressing the stack-protector guard
  -mstack-protector-guard=<value>
                          Use the given guard (global, tls) for addressing the stack-protector guard
  -mstackrealign          Force realign the stack at entry to every function
  -msve-vector-bits=<value>
                          Specify the size in bits of an SVE vector register. Defaults to the vector length agnostic value of "scalable". (AArch64 only)
  -msvr4-struct-return    Return small structs in registers (PPC32 only)
  -mtargetos=<value>      Set the deployment target to be the specified OS and OS version
  -mtgsplit               Enable threadgroup split execution mode (AMDGPU only)
  -mthread-model <value>  The thread model to use, e.g. posix, single (posix by default)
  -mtls-direct-seg-refs   Enable direct TLS access through segment registers (default)
  -mtls-size=<value>      Specify bit size of immediate TLS offsets (AArch64 ELF only): 12 (for 4KB) | 24 (for 16MB, default) | 32 (for 4GB) | 48 (for 256TB, needs -mcmodel=large)
  -mtp=<value>            Thread pointer access method (AArch32/AArch64 only)
  -mtune=<value>          Only supported on X86 and RISC-V. Otherwise accepted for compatibility with GCC.
  -MT <value>             Specify name of main file output in depfile
  -munaligned-access      Allow memory accesses to be unaligned (AArch32/AArch64 only)
  -munsafe-fp-atomics     Enable unsafe floating point atomic instructions (AMDGPU only)
  -mvscale-max=<value>    Specify the vscale maximum. Defaults to the vector length agnostic value of "0". (AArch64 only)
  -mvscale-min=<value>    Specify the vscale minimum. Defaults to "1". (AArch64 only)
  -MV                     Use NMake/Jom format for the depfile
  -mwavefrontsize64       Specify wavefront size 64 mode (AMDGPU only)
  -M                      Like -MD, but also implies -E and writes to stdout by default
  --no-cuda-include-ptx=<value>
                          Do not include PTX for the following GPU architecture (e.g. sm_35) or \'all\'. May be specified more than once.
  --no-cuda-version-check Don\'t error out if the detected version of the CUDA install is too low for the requested CUDA gpu architecture.
  --no-gpu-bundle-output  Do not bundle output files of HIP device compilation
  --no-offload-arch=<value>
                          Remove CUDA/HIP offloading device architecture (e.g. sm_35, gfx906) from the list of devices to compile for. \'all\' resets the list to its default value.
  --no-system-header-prefix=<prefix>
                          Treat all #include paths starting with <prefix> as not including a system header.
  -nobuiltininc           Disable builtin #include directories
  -nogpuinc               Do not add include paths for CUDA/HIP and do not include the default CUDA/HIP wrapper headers
  -nogpulib               Do not link device library for CUDA/HIP device compilation
  -nohipwrapperinc        Do not include the default HIP wrapper headers and include paths
  -nostdinc++             Disable standard #include directories for the C++ standard library
  -ObjC++                 Treat source input files as Objective-C++ inputs
  -objcmt-allowlist-dir-path=<value>
                          Only modify files with a filename contained in the provided directory path
  -objcmt-atomic-property Make migration to \'atomic\' properties
  -objcmt-migrate-all     Enable migration to modern ObjC
  -objcmt-migrate-annotation
                          Enable migration to property and method annotations
  -objcmt-migrate-designated-init
                          Enable migration to infer NS_DESIGNATED_INITIALIZER for initializer methods
  -objcmt-migrate-instancetype
                          Enable migration to infer instancetype for method result type
  -objcmt-migrate-literals
                          Enable migration to modern ObjC literals
  -objcmt-migrate-ns-macros
                          Enable migration to NS_ENUM/NS_OPTIONS macros
  -objcmt-migrate-property-dot-syntax
                          Enable migration of setter/getter messages to property-dot syntax
  -objcmt-migrate-property
                          Enable migration to modern ObjC property
  -objcmt-migrate-protocol-conformance
                          Enable migration to add protocol conformance on classes
  -objcmt-migrate-readonly-property
                          Enable migration to modern ObjC readonly property
  -objcmt-migrate-readwrite-property
                          Enable migration to modern ObjC readwrite property
  -objcmt-migrate-subscripting
                          Enable migration to modern ObjC subscripting
  -objcmt-ns-nonatomic-iosonly
                          Enable migration to use NS_NONATOMIC_IOSONLY macro for setting property\'s \'atomic\' attribute
  -objcmt-returns-innerpointer-property
                          Enable migration to annotate property with NS_RETURNS_INNER_POINTER
  -objcmt-whitelist-dir-path=<value>
                          Alias for -objcmt-allowlist-dir-path
  -ObjC                   Treat source input files as Objective-C inputs
  -object-file-name=<file>
                          Set the output <file> for debug infos
  --offload-arch=<value>  CUDA offloading device architecture (e.g. sm_35), or HIP offloading target ID in the form of a device architecture followed by target ID features delimited by a colon. Each target ID feature is a pre-defined string followed by a plus or minus sign (e.g. gfx908:xnack+:sramecc-).  May be specified more than once.
  --offload=<value>       Specify comma-separated list of offloading target triples (CUDA and HIP only)
  -o <file>               Write output to <file>
  -pedantic               Warn on language extensions
  -pg                     Enable mcount instrumentation
  -pipe                   Use pipes between commands, when possible
  --precompile            Only precompile the input
  -print-effective-triple Print the effective target triple
  -print-file-name=<file> Print the full library path of <file>
  -print-ivar-layout      Enable Objective-C Ivar layout bitmap print trace
  -print-libgcc-file-name Print the library path for the currently used compiler runtime library ("libgcc.a" or "libclang_rt.builtins.*.a")
  -print-multiarch        Print the multiarch target triple
  -print-prog-name=<name> Print the full program path of <name>
  -print-resource-dir     Print the resource directory pathname
  -print-rocm-search-dirs Print the paths used for finding ROCm installation
  -print-runtime-dir      Print the directory pathname containing clangs runtime libraries
  -print-search-dirs      Print the paths used for finding libraries and programs
  -print-supported-cpus   Print supported cpu models for the given target (if target is not specified, it will print the supported cpus for the default target)
  -print-target-triple    Print the normalized target triple
  -print-targets          Print the registered targets
  -pthread                Support POSIX threads in generated code
  --ptxas-path=<value>    Path to ptxas (used for compiling CUDA code)
  -P                      Disable linemarker output in -E mode
  -Qn                     Do not emit metadata containing compiler name and version
  -Qunused-arguments      Don\'t emit warning for unused driver arguments
  -Qy                     Emit metadata containing compiler name and version
  -relocatable-pch        Whether to build a relocatable precompiled header
  -rewrite-legacy-objc    Rewrite Legacy Objective-C source to C++
  -rewrite-objc           Rewrite Objective-C source to C++
  --rocm-device-lib-path=<value>
                          ROCm device library path. Alternative to rocm-path.
  --rocm-path=<value>     ROCm installation path, used for finding and automatically linking required bitcode libraries.
  -Rpass-analysis=<value> Report transformation analysis from optimization passes whose name matches the given POSIX regular expression
  -Rpass-missed=<value>   Report missed transformations by optimization passes whose name matches the given POSIX regular expression
  -Rpass=<value>          Report transformations performed by optimization passes whose name matches the given POSIX regular expression
  -rtlib=<value>          Compiler runtime library to use
  -R<remark>              Enable the specified remark
  -save-stats=<value>     Save llvm statistics.
  -save-stats             Save llvm statistics.
  -save-temps=<value>     Save intermediate compilation results.
  -save-temps             Save intermediate compilation results
  -serialize-diagnostics <value>
                          Serialize compiler diagnostics to a file
  -shared-libsan          Dynamically link the sanitizer runtime
  --start-no-unused-arguments
                          Don\'t emit warnings about unused arguments for the following arguments
  -static-libsan          Statically link the sanitizer runtime
  -static-openmp          Use the static host OpenMP runtime while linking.
  -std=<value>            Language standard to compile for
  -stdlib++-isystem <directory>
                          Use directory as the C++ standard library include path
  -stdlib=<value>         C++ standard library to use
  -sycl-std=<value>       SYCL language standard to compile for.
  --system-header-prefix=<prefix>
                          Treat all #include paths starting with <prefix> as including a system header.
  -S                      Only run preprocess and compilation steps
  --target=<value>        Generate code for the given target
  -Tbss <addr>            Set starting address of BSS to <addr>
  -Tdata <addr>           Set starting address of DATA to <addr>
  -time                   Time individual commands
  -traditional-cpp        Enable some traditional CPP emulation
  -trigraphs              Process trigraph sequences
  -Ttext <addr>           Set starting address of TEXT to <addr>
  -T <script>             Specify <script> as linker script
  -undef                  undef all system defines
  -unwindlib=<value>      Unwind library to use
  -U <macro>              Undefine macro <macro>
  --verify-debug-info     Verify the binary representation of debug output
  -verify-pch             Load and verify that a pre-compiled header file is not stale
  --version               Print version information
  -v                      Show commands to run and use verbose output
  -Wa,<arg>               Pass the comma separated arguments in <arg> to the assembler
  -Wdeprecated            Enable warnings for deprecated constructs and define __DEPRECATED
  -Wl,<arg>               Pass the comma separated arguments in <arg> to the linker
  -working-directory <value>
                          Resolve file paths relative to the specified directory
  -Wp,<arg>               Pass the comma separated arguments in <arg> to the preprocessor
  -W<warning>             Enable the specified warning
  -w                      Suppress all warnings
  -Xanalyzer <arg>        Pass <arg> to the static analyzer
  -Xarch_device <arg>     Pass <arg> to the CUDA/HIP device compilation
  -Xarch_host <arg>       Pass <arg> to the CUDA/HIP host compilation
  -Xassembler <arg>       Pass <arg> to the assembler
  -Xclang <arg>           Pass <arg> to the clang compiler
  -Xcuda-fatbinary <arg>  Pass <arg> to fatbinary invocation
  -Xcuda-ptxas <arg>      Pass <arg> to the ptxas assembler
  -Xlinker <arg>          Pass <arg> to the linker
  -Xopenmp-target=<triple> <arg>
                          Pass <arg> to the target offloading toolchain identified by <triple>.
  -Xopenmp-target <arg>   Pass <arg> to the target offloading toolchain.
  -Xpreprocessor <arg>    Pass <arg> to the preprocessor
  -x <language>           Treat subsequent input files as having type <language>
  -z <arg>                Pass -z <arg> to the linker

                    
                    ）',
                    "command" => 'clang [options] file...',
                    "examples" => array(),
                ),
                "edb-debugger" => array(
                    "title" => 'edb-debugger : ',
                    "describe" => '一个跨平台的AArch32/x86/x86-64调试器（图形化界面）',
                    "command" => 'edb',
                    "examples" => array(),
                ),
                "nasm-shell" => array(
                    "title" => 'nasm-shell : ',
                    "describe" => '逆向工程工具（可根据汇编指令生成动态机器码，一般适用于x32环境，对于x64汇编代码的支持还并不是很好）',
                    "command" => 'nasm_shell.rb',
                    "examples" => array(),
                ),
                "radare2" => array(
                    "title" => 'radare2 : ',
                    "describe" => '逆向分析工具（
                    
Options:

 --           run radare2 without opening any file
 -            same as \'r2 malloc://512\'
 =            read file from stdin (use -i and -c to run cmds)
 -=           perform !=! command to run all commands remotely
 -0           print \x00 after init and every command
 -2           close stderr file descriptor (silent warning messages)
 -a [arch]    set asm.arch
 -A           run \'aaa\' command to analyze all referenced code
 -b [bits]    set asm.bits
 -B [baddr]   set base address for PIE binaries
 -c \'cmd..\'   execute radare command
 -C           file is host:port (alias for -c+=http://%s/cmd/)
 -d           debug the executable \'file\' or running process \'pid\'
 -D [backend] enable debug mode (e cfg.debug=true)
 -e k=v       evaluate config var
 -f           block size = file size
 -F [binplug] force to use that rbin plugin
 -h, -hh      show help message, -hh for long
 -H ([var])   display variable
 -i [file]    run script file
 -I [file]    run script file before the file is opened
 -j           use json for -v, -L and maybe others
 -k [OS/kern] set asm.os (linux, macos, w32, netbsd, ...)
 -l [lib]     load plugin file
 -L           list supported IO plugins
 -m [addr]    map file at given address (loadaddr)
 -M           do not demangle symbol names
 -n, -nn      do not load RBin info (-nn only load bin structures)
 -N           do not load user settings and scripts
 -NN          do not load any script or plugin
 -q           quiet mode (no prompt) and quit after -i
 -qq          quit after running all -c and -i
 -Q           quiet mode (no prompt) and quit faster (quickLeak=true)
 -p [prj]     use project, list if no arg, load if no file
 -P [file]    apply rapatch file and quit
 -r [rarun2]  specify rarun2 profile to load (same as -e dbg.profile=X)
 -R [rr2rule] specify custom rarun2 directive
 -s [addr]    initial seek
 -S           start r2 in sandbox mode
 -T           do not compute file hashes
 -u           set bin.filter=false to get raw sym/sec/cls names
 -v, -V       show radare2 version (-V show lib versions)
 -w           open file in write mode
 -x           open without exec-flag (asm.emu will not work), See io.exec
 -X           same as -e bin.usextr=false (useful for dyldcache)
 -z, -zz      do not load strings or load them even in raw
                    
                    ）',
                    "command" => 'r2 [-ACdfLMnNqStuvwzX] [-P patch] [-p prj] [-a arch] [-b bits] [-i file]
                                      [-s addr] [-B baddr] [-m maddr] [-c cmd] [-e k=v] file|pid|-|--|=',
                    "examples" => array(),
                ),
            ),
        );
        Class_Base_Auth::check_permission();
        if (!is_cli()) {
            $_form_top = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Reverse Engineering Commands</div>';
            $_form = array(
                "action" => "/guide/penetration_test_commands",
                "inputs" => array(),
                "textareas" => array(),
                "submit" => array(
                    "value" => " return to Penetration Test Commands ",
                    "display" => true,
                ),
                "reset" => array(
                    "display" => false,
                ),
            );
            self::_commands_format_to_form_textareas($_common_commands, $_form);
            $_top = Class_View_Top::top();
            $_body = array(
                "menu" => Class_View_Guide_PenetrationTestCommands_Menu::menu(),
                "content" => (($_form_top) . Class_View::form_body($_form)),
            );
            $_bottom = Class_View_Bottom::bottom();
            Class_Base_Response::output(Class_View::index($_top, $_body, $_bottom), "text", 0);
        }
        return null;
    }

    public static function vulnerability_exploitation($params = array())
    {
        if ((!is_cli()) && (!Class_Base_Auth::is_login())) {
            Class_Base_Response::redirect("/login");
            return null;
        }
        $_common_commands = array(
            "vulnerability_exploitation" => array(
                "armitage" => array(
                    "title" => 'armitage : ',
                    "describe" => '图形化的Metasploit软件（底层基于命令行方式的Metasploit-Framework）',
                    "command" => 'armitage',
                    "examples" => array(),
                ),
                "crackmapexec" => array(
                    "title" => 'crackmapexec : ',
                    "describe" => '针对大型Windows活动目录(AD)的后渗透利用工具（
                    
options:

  -h, --help            show this help message and exit
  
  -t THREADS            set how many concurrent threads to use (default: 100)
  
  --timeout TIMEOUT     max timeout in seconds of each thread (default: None)
  
  --jitter INTERVAL     sets a random delay between each connection (default: None)
  
  --darrell             give Darrell a hand
  
  --verbose             enable verbose output


protocols:
  available protocols

  {smb,ftp,mssql,ldap,winrm,ssh,rdp}
    smb                 own stuff using SMB
    ftp                 own stuff using FTP
    mssql               own stuff using MSSQL
    ldap                own stuff using LDAP
    winrm               own stuff using WINRM
    ssh                 own stuff using SSH
    rdp                 own stuff using RDP
                    
                    ）',
                    "command" => 'crackmapexec [-h] [-t THREADS] [--timeout TIMEOUT] [--jitter INTERVAL] [--darrell] [--verbose] {smb,ftp,mssql,ldap,winrm,ssh,rdp} ...',
                    "examples" => array(),
                ),
                "metasploit-framework" => array(
                    "title" => 'metasploit-framework : ',
                    "describe" => '编写、测试和使用exploit代码的完善环境（
                    
Core Commands
=============

    Command       Description
    -------       -----------
    
    ?             Help menu
    
    banner        Display an awesome metasploit banner
    
    cd            Change the current working directory
    
    color         Toggle color
    
    connect       Communicate with a host
    
    debug         Display information useful for debugging
    
    exit          Exit the console
    
    features      Display the list of not yet released features that can be op ted in to
    
    get           Gets the value of a context-specific variable
    
    getg          Gets the value of a global variable
    
    grep          Grep the output of another command
    
    help          Help menu
    
    history       Show command history
    
    load          Load a framework plugin
    
    quit          Exit the console
    
    repeat        Repeat a list of commands
    
    route         Route traffic through a session
    
    save          Saves the active datastores
    
    sessions      Dump session listings and display information about sessions
    
    set           Sets a context-specific variable to a value
    
    setg          Sets a global variable to a value
    
    sleep         Do nothing for the specified number of seconds
    
    spool         Write console output into a file as well the screen
    
    threads       View and manipulate background threads
    
    tips          Show a list of useful productivity tips
    
    unload        Unload a framework plugin
    
    unset         Unsets one or more context-specific variables
    
    unsetg        Unsets one or more global variables
    
    version       Show the framework and console library version numbers


Module Commands
===============

    Command       Description
    -------       -----------
    
    advanced      Displays advanced options for one or more modules
    
    back          Move back from the current context
    
    clearm        Clear the module stack
    
    favorite      Add module(s) to the list of favorite modules
    
    favorites     Print the list of favorite modules (alias for `show favorites`)
    
    info          Displays information about one or more modules
    
    listm         List the module stack
    
    loadpath      Searches for and loads modules from a path
    
    options       Displays global options or for one or more modules
    
    popm          Pops the latest module off the stack and makes it active
    
    previous      Sets the previously loaded module as the current module
    
    pushm         Pushes the active or list of modules onto the module stack
    
    reload_all    Reloads all modules from all defined module paths
    
    search        Searches module names and descriptions
    
    show          Displays modules of a given type, or all modules
    
    use           Interact with a module by name or search term/index


Job Commands
============

    Command       Description
    -------       -----------
    
    handler       Start a payload handler as job
    
    jobs          Displays and manages jobs
    
    kill          Kill a job
    
    rename_job    Rename a job


Resource Script Commands
========================

    Command       Description
    -------       -----------
    
    makerc        Save commands entered since start to a file
    
    resource      Run the commands stored in a file


Database Backend Commands
=========================

    Command       Description
    -------       -----------
    
    analyze       Analyze database information about a specific address or address range
    
    db_connect    Connect to an existing data service
    
    db_disconnect  Disconnect from the current data service 
    
    db_export     Export a file containing the contents of the database
    
    db_import     Import a scan result file (filetype will be auto-detected)
    
    db_nmap       Executes nmap and records the output automatically
    
    db_rebuild_cache  Rebuilds the database-stored module cache (deprecated) 
    
    db_remove     Remove the saved data service entry
    
    db_save       Save the current data service connection as the default to reconnect on startup
    
    db_status     Show the current data service status
    
    hosts         List all hosts in the database
    
    klist         List Kerberos tickets in the database
    
    loot          List all loot in the database
    
    notes         List all notes in the database
    
    services      List all services in the database
    
    vulns         List all vulnerabilities in the database
    
    workspace     Switch between database workspaces


Credentials Backend Commands
============================

    Command       Description
    -------       -----------
    
    creds         List all credentials in the database


Developer Commands
==================

    Command       Description
    -------       -----------
    
    edit          Edit the current module or a file with the preferred editor
    
    irb           Open an interactive Ruby shell in the current context
    
    log           Display framework.log paged to the end if possible
    
    pry           Open the Pry debugger on the current module or Framework
    
    reload_lib    Reload Ruby library files from specified paths
    
    time          Time how long it takes to run a particular command


msfconsole
==========

`msfconsole` is the primary interface to Metasploit Framework. There is quite a
lot that needs go here, please be patient and keep an eye on this space!

Building ranges and lists
-------------------------

Many commands and options that take a list of things can use ranges to avoid
having to manually list each desired thing. All ranges are inclusive.

### Ranges of IDs

Commands that take a list of IDs can use ranges to help. Individual IDs must be
separated by a `,` (no space allowed) and ranges can be expressed with either
`-` or `..`.

### Ranges of IPs

There are several ways to specify ranges of IP addresses that can be mixed
together. The first way is a list of IPs separated by just a ` ` (ASCII space),
with an optional `,`. The next way is two complete IP addresses in the form of
`BEGINNING_ADDRESS-END_ADDRESS` like `127.0.1.44-127.0.2.33`. CIDR
specifications may also be used, however the whole address must be given to
Metasploit like `127.0.0.0/8` and not `127/8`, contrary to the RFC.
Additionally, a netmask can be used in conjunction with a domain name to
dynamically resolve which block to target. All these methods work for both IPv4
and IPv6 addresses. IPv4 addresses can also be specified with special octet
ranges from the [NMAP target
specification](https://nmap.org/book/man-target-specification.html)

### Examples

Terminate the first sessions:

    sessions -k 1

Stop some extra running jobs:

    jobs -k 2-6,7,8,11..15

Check a set of IP addresses:

    check 127.168.0.0/16, 127.0.0-2.1-4,15 127.0.0.255

Target a set of IPv6 hosts:

    set RHOSTS fe80::3990:0000/110, ::1-::f0f0

Target a block from a resolved domain name:

    set RHOSTS www.example.test/24

                    
                    ）',
                    "command" => 'msfconsole',
                    "examples" => array(
                        array(
                            "title" => "",
                            "describe" => "初始化框架数据库（基于postgresql）与启动渗透测试环境",
                            "command" => "sudo msfdb init && msfconsole",
                        ),
                    ),
                ),
                "msf-payload-creator" => array(
                    "title" => 'msf-payload-creator : ',
                    "describe" => 'Metasploit渗透载荷生成工具（
                    
 <TYPE>:
   + APK
   + ASP
   + ASPX
   + Bash [.sh]
   + Java [.jsp]
   + Linux [.elf]
   + OSX [.macho]
   + Perl [.pl]
   + PHP
   + Powershell [.ps1]
   + Python [.py]
   + Tomcat [.war]
   + Windows [.exe // .exe // .dll]


 Rather than putting <DOMAIN/IP>, you can do a interface and MSFPC will detect that IP address.
 
 
 Missing <DOMAIN/IP> will default to the IP menu.

 Missing <PORT> will default to 443.


 <CMD> is a standard/native command prompt/terminal to interactive with.
 
 
 <MSF> is a custom cross platform shell, gaining the full power of Metasploit.
 
 
 Missing <CMD/MSF> will default to <MSF> where possible.
 

 <BIND> opens a port on the target side, and the attacker connects to them. Commonly blocked with ingress firewalls rules on the target.
 
 
 <REVERSE> makes the target connect back to the attacker. The attacker needs an open port. Blocked with engress firewalls rules on the target.
 
 
 Missing <BIND/REVERSE> will default to <REVERSE>.
 

 <STAGED> splits the payload into parts, making it smaller but dependent on Metasploit.
 
 
 <STAGELESS> is the complete standalone payload. More \'stable\' than <STAGED>.
 
 
 Missing <STAGED/STAGELESS> will default to <STAGED> where possible.
 

 <TCP> is the standard method to connecting back. This is the most compatible with TYPES as its RAW. Can be easily detected on IDSs.
 
 
 <HTTP> makes the communication appear to be HTTP traffic (unencrypted). Helpful for packet inspection, which limit port access on protocol - e.g. TCP 80.
 
 
 <HTTPS> makes the communication appear to be (encrypted) HTTP traffic using as SSL. Helpful for packet inspection, which limit port access on protocol - e.g. TCP 443.
 
 
 <FIND_PORT> will attempt every port on the target machine, to find a way out. Useful with stick ingress/engress firewall rules. Will switch to \'allports\' based on <TYPE>.
 
 
 Missing <TCP/HTTP/HTTPS/FIND_PORT> will default to <TCP>.
 

 <BATCH> will generate as many combinations as possible: <TYPE>, <CMD + MSF>, <BIND + REVERSE>, <STAGED + STAGELESS> & <TCP + HTTP + HTTPS + FIND_PORT> 
 
 
 <LOOP> will just create one of each <TYPE>.
 

 <VERBOSE> will display more information.
                    
                    ）',
                    "command" => '/usr/bin/msfpc <TYPE> (<DOMAIN/IP>) (<PORT>) (<CMD/MSF>) (<BIND/REVERSE>) (<STAGED/STAGELESS>) (<TCP/HTTP/HTTPS/FIND_PORT>) (<BATCH/LOOP>) (<VERBOSE>)',
                    "examples" => array(
                        array(
                            "title" => "",
                            "describe" => "Windows & manual IP （Windows手动IP（&M））",
                            "command" => "/usr/bin/msfpc windows 192.168.1.10",
                        ),
                        array(
                            "title" => "",
                            "describe" => "Linux, eth0's IP & manual port （Linux，eth0的IP和手动端口）",
                            "command" => "/usr/bin/msfpc elf bind eth0 4444",
                        ),
                        array(
                            "title" => "",
                            "describe" => "Python, stageless command prompt （Python，无阶段命令提示符）",
                            "command" => "/usr/bin/msfpc stageless cmd py https",
                        ),
                        array(
                            "title" => "",
                            "describe" => "A payload for every type, using eth1's IP （每种类型的有效负载，使用eth1的IP）",
                            "command" => "/usr/bin/msfpc verbose loop eth1",
                        ),
                        array(
                            "title" => "",
                            "describe" => "All possible Meterpreter payloads, using WAN IP （所有可能的Meteorpeter有效载荷，使用WAN IP）",
                            "command" => "/usr/bin/msfpc msf batch wan",
                        ),
                        array(
                            "title" => "",
                            "describe" => "Help screen, with even more information （帮助屏幕，包含更多信息）",
                            "command" => "/usr/bin/msfpc help verbose",
                        ),
                    ),
                ),
                "searchsploit" => array(
                    "title" => 'searchsploit : ',
                    "describe" => '用于Exploit-DB的命令行搜索工具（ExploitDB是一个面向全世界信息安全专业人士的漏洞提交平台，Exploit-DB是一个漏洞平台对应的漏洞信息仓库）（
                    
=========
 Options 
=========

## Search Terms
   -c, --case     [term]      Perform a case-sensitive search (Default is inSEnsITiVe)
   
   -e, --exact    [term]      Perform an EXACT & order match on exploit title (Default is an AND match on each term) [Implies "-t"] ; e.g. "WordPress 4.1" would not be detect "WordPress Core 4.1")
   
   -s, --strict               Perform a strict search, so input values must exist, disabling fuzzy search for version range ; e.g. "1.1" would not be detected in "1.0 < 1.3")
   
   -t, --title    [term]      Search JUST the exploit title (Default is title AND the file\'s path)
   
       --exclude="term"       Remove values from results. By using "|" to separate, you can chain multiple values ; e.g. --exclude="term1|term2|term3"
       
       --cve      [CVE]       Search for Common Vulnerabilities and Exposures (CVE) value ;


## Output

   -j, --json     [term]      Show result in JSON format
   
   -o, --overflow [term]      Exploit titles are allowed to overflow their columns
   
   -p, --path     [EDB-ID]    Show the full path to an exploit (and also copies the path to the clipboard if possible)
   
   -v, --verbose              Display more information in output
   
   -w, --www      [term]      Show URLs to Exploit-DB.com rather than the local path
   
       --id                   Display the EDB-ID value rather than local path
       
       --disable-colour       Disable colour highlighting in search results


## Non-Searching

   -m, --mirror   [EDB-ID]    Mirror (aka copies) an exploit to the current working directory
   
   -x, --examine  [EDB-ID]    Examine (aka opens) the exploit using $PAGER


## Non-Searching

   -h, --help                 Show this help screen
   
   -u, --update               Check for and install any exploitdb package updates (brew, deb & git)


## Automation

       --nmap     [file.xml]  Checks all results in Nmap\'s XML output with service version ; e.g.: nmap [host] -sV -oX file.xml


=======
 Notes 
=======
 * You can use any number of search terms
 * By default, search terms are not case-sensitive, ordering is irrelevant, and will search between version ranges
   * Use \'-c\' if you wish to reduce results by case-sensitive searching
   * And/Or \'-e\' if you wish to filter results by using an exact match
   * And/Or \'-s\' if you wish to look for an exact version match
 * Use \'-t\' to exclude the file\'s path to filter the search results
   * Remove false positives (especially when searching using numbers - i.e. versions)
 * When using \'--nmap\', adding \'-v\' (verbose), it will search for even more combinations
 * When updating or displaying help, search terms will be ignored
                    
                    ）',
                    "command" => 'searchsploit [options] term1 [term2] ... [termN]',
                    "examples" => array(
                        array(
                            "title" => "",
                            "describe" => "123 （ ）",
                            "command" => "searchsploit afd windows local",
                        ),
                        array(
                            "title" => "",
                            "describe" => "123 （ ）",
                            "command" => "searchsploit -t oracle windows",
                        ),
                        array(
                            "title" => "",
                            "describe" => "123 （ ）",
                            "command" => "searchsploit -p 39446",
                        ),
                        array(
                            "title" => "",
                            "describe" => "123 （ ）",
                            "command" => 'searchsploit linux kernel 3.2 --exclude="(PoC)|/dos/"',
                        ),
                        array(
                            "title" => "",
                            "describe" => "123 （ ）",
                            "command" => "searchsploit -s Apache Struts 2.0.0",
                        ),
                        array(
                            "title" => "",
                            "describe" => "123 （ ）",
                            "command" => "searchsploit linux reverse password",
                        ),
                        array(
                            "title" => "",
                            "describe" => "123 （ ）",
                            "command" => "searchsploit -j 55555 | jq",
                        ),
                        array(
                            "title" => "",
                            "describe" => "123 （ ）",
                            "command" => "searchsploit --cve 2021-44228",
                        ),
                        array(
                            "title" => "",
                            "describe" => "For more examples, see the manual: https://www.exploit-db.com/searchsploit （有关更多示例，请参阅手册：https://www.exploit-db.com/searchsploit）",
                            "command" => "https://www.exploit-db.com/searchsploit",
                        ),
                    ),
                ),
                "social-engineering-toolkit ( root )" => array(
                    "title" => 'social-engineering-toolkit ( root ) : ',
                    "describe" => '社会工程工具包（
                    
1) Social-Engineering Attacks （社会工程攻击）

2) Penetration Testing (Fast-Track) （渗透测试（快速通道））

3) Third Party Modules （第三方模块）

4) Update the Social-Engineer Toolkit （更新社会工程师工具包）

5) Update SET configuration （更新 SET 配置）

6) Help, Credits, and About （帮助、鸣谢和关于）


1) Spear-Phishing Attack Vectors （鱼叉式网络钓鱼攻击）

2) Website Attack Vectors （网站攻击）

3) Infectious Media Generator （传染性媒体生成器）

4) Create a Payload and Listener （创建有效负载和侦听器）

5) Mass Mailer Attack （群发邮件攻击）

6) Arduino-Based Attack Vector （基于 Arduino 的攻击）

7) Wireless Access Point Attack Vector （无线接入点攻击）

8) QRCode Generator Attack Vector （二维码攻击生成器）

9) Powershell Attack Vectors （Powershell 攻击）

10) Third Party Modules （第三方模块）

                    
                    ）',
                    "command" => 'social-engineering-toolkit',
                    "examples" => array(),
                ),
            ),
        );
        Class_Base_Auth::check_permission();
        if (!is_cli()) {
            $_form_top = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Vulnerability Exploitation Commands</div>';
            $_form = array(
                "action" => "/guide/penetration_test_commands",
                "inputs" => array(),
                "textareas" => array(),
                "submit" => array(
                    "value" => " return to Penetration Test Commands ",
                    "display" => true,
                ),
                "reset" => array(
                    "display" => false,
                ),
            );
            self::_commands_format_to_form_textareas($_common_commands, $_form);
            $_top = Class_View_Top::top();
            $_body = array(
                "menu" => Class_View_Guide_PenetrationTestCommands_Menu::menu(),
                "content" => (($_form_top) . Class_View::form_body($_form)),
            );
            $_bottom = Class_View_Bottom::bottom();
            Class_Base_Response::output(Class_View::index($_top, $_body, $_bottom), "text", 0);
        }
        return null;
    }

    public static function sniff_deception($params = array())
    {
        if ((!is_cli()) && (!Class_Base_Auth::is_login())) {
            Class_Base_Response::redirect("/login");
            return null;
        }
        $_common_commands = array(
            "sniff_deception" => array(
                "ettercap-graphical" => array(
                    "title" => 'ettercap-graphical : ',
                    "describe" => '图形化的网络抓包软件',
                    "command" => 'ettercap-graphical',
                    "examples" => array(),
                ),
                "macchanger" => array(
                    "title" => 'macchanger : ',
                    "describe" => '网卡（MAC）地址更改工具（
                    
Options:

  -h,  --help                   Print this help
  
  -V,  --version                Print version and exit
  
  -s,  --show                   Print the MAC address and exit
  
  -e,  --ending                 Don\'t change the vendor bytes
  
  -a,  --another                Set random vendor MAC of the same kind
  
  -A                            Set random vendor MAC of any kind
  
  -p,  --permanent              Reset to original, permanent hardware MAC
  
  -r,  --random                 Set fully random MAC
  
  -l,  --list[=keyword]         Print known vendors
  
  -b,  --bia                    Pretend to be a burned-in-address
  
  -m,  --mac=XX:XX:XX:XX:XX:XX
  
       --mac XX:XX:XX:XX:XX:XX  Set the MAC XX:XX:XX:XX:XX:XX
       

Report bugs to https://github.com/alobbs/macchanger/issues
                    
                    ）',
                    "command" => 'macchanger [options] device',
                    "examples" => array(),
                ),
                "minicom" => array(
                    "title" => 'minicom : ',
                    "describe" => '串口通信工具（
                    
Options:

  -b, --baudrate         : set baudrate (ignore the value from config)
  
  -D, --device           : set device name (ignore the value from config)
  
  -s, --setup            : enter setup mode
  
  -o, --noinit           : do not initialize modem & lockfiles at startup
  
  -m, --metakey          : use meta or alt key for commands
  
  -M, --metakey8         : use 8bit meta key for commands
  
  -l, --ansi             : literal; assume screen uses non IBM-PC character set
  
  -L, --iso              : don\'t assume screen uses ISO8859
  
  -w, --wrap             : Linewrap on
  
  -H, --displayhex       : display output in hex
  
  -z, --statline         : try to use terminal\'s status line
  
  -7, --7bit             : force 7bit mode
  
  -8, --8bit             : force 8bit mode
  
  -c, --color=on/off     : ANSI style color usage on or off
  
  -a, --attrib=on/off    : use reverse or highlight attributes on or off
  
  -t, --term=TERM        : override TERM environment variable
  
  -S, --script=SCRIPT    : run SCRIPT at startup
  
  -d, --dial=ENTRY       : dial ENTRY from the dialing directory
  
  -p, --ptty=TTYP        : connect to pseudo terminal
  
  -C, --capturefile=FILE : start capturing to FILE
  
  --capturefile-buffer-mode=MODE : set buffering mode of capture file
  
  -F, --statlinefmt      : format of status line
  
  -R, --remotecharset    : character set of communication partner
  
  -v, --version          : output version information and exit
  
  -h, --help             : show help
  
  configuration          : configuration file to use
                    
                    ）',
                    "command" => 'minicom [OPTION]... [configuration]',
                    "examples" => array(),
                ),
                "mitmproxy" => array(
                    "title" => 'mitmproxy : ',
                    "describe" => '网络代理与抓包工具（
                    
options:

  -h, --help            show this help message and exit
  
  --version             show version number and exit
  
  --options             Show all options and their default values
  
  --commands            Show all commands and their signatures
  
  --set option[=value]  Set an option. When the value is omitted, booleans are set to true, strings and integers are set to None (if
                        permitted), and sequences are emptied. Boolean values
                        can be true, false or toggle. Sequences are set using
                        multiple invocations to set for the same option.
                        
  -q, --quiet           Quiet.
  
  -v, --verbose         Increase log verbosity.
  
  --mode MODE, -m MODE  The proxy server type(s) to spawn. Can be passed
                        multiple times. Mitmproxy supports "regular" (HTTP),
                        "transparent", "socks5", "reverse:SPEC", and
                        "upstream:SPEC" proxy servers. For reverse and
                        upstream proxy modes, SPEC is host specification in
                        the form of "http[s]://host[:port]". You may append
                        `@listen_port` or `@listen_host:listen_port` to
                        override `listen_host` or `listen_port` for a specific
                        proxy mode. Features such as client playback will use
                        the first mode to determine which upstream server to
                        use. May be passed multiple times.
                        
  --no-anticache
  --anticache           Strip out request headers that might cause the server
                        to return 304-not-modified.
                        
  --no-showhost
  --showhost            Use the Host header to construct URLs for display.
  
  --rfile PATH, -r PATH
                        Read flows from file.
                        
  --scripts SCRIPT, -s SCRIPT
                        Execute a script. May be passed multiple times.
                        
  --stickycookie FILTER
                        Set sticky cookie filter. Matched against requests.
                        
  --stickyauth FILTER   Set sticky auth filter. Matched against requests.
  
  --save-stream-file PATH, -w PATH
                        Stream flows to file as they arrive. Prefix path with
                        + to append. The full path can use python strftime()
                        formating, missing directories are created as needed.
                        A new file is opened every time the formatted string
                        changes.
                        
  --no-anticomp
  --anticomp            Try to convince servers to send us un-compressed data.
  
  --console-layout {horizontal,single,vertical}
                        Console layout.
  --no-console-layout-headers
  --console-layout-headers
                        Show layout component headers


Proxy Options:

  --listen-host HOST    Address to bind proxy server(s) to (may be overridden for individual modes, see `mode`).
  
  --listen-port PORT, -p PORT
                        Port to bind proxy server(s) to (may be overridden for
                        individual modes, see `mode`). By default, the port is
                        mode-specific. The default regular HTTP proxy spawns
                        on port 8080.
                        
  --no-server, -n
  --server              Start a proxy server. Enabled by default.
  
  --ignore-hosts HOST   Ignore host and forward all traffic without processing
                        it. In transparent mode, it is recommended to use an
                        IP address (range), not the hostname. In regular mode,
                        only SSL traffic is ignored and the hostname should be
                        used. The supplied value is interpreted as a regular
                        expression and matched on the ip or the hostname. May
                        be passed multiple times.
                        
  --allow-hosts HOST    Opposite of --ignore-hosts. May be passed multiple times.
  
  --tcp-hosts HOST      Generic TCP SSL proxy mode for all hosts that match
                        the pattern. Similar to --ignore-hosts, but SSL
                        connections are intercepted. The communication
                        contents are printed to the log in verbose mode. May
                        be passed multiple times.
                        
  --upstream-auth USER:PASS
                        Add HTTP Basic authentication to upstream proxy and
                        reverse proxy requests. Format: username:password.
                        
  --proxyauth SPEC      Require proxy authentication. Format: "username:pass",
                        "any" to accept any user/pass combination, "@path" to
                        use an Apache htpasswd file, or "ldap[s]:url_server_ld
                        ap[:port]:dn_auth:password:dn_subtree" for LDAP
                        authentication.
                        
  --no-rawtcp
  --rawtcp              Enable/disable raw TCP connections. TCP connections
                        are enabled by default.
  --no-http2
  --http2               Enable/disable HTTP/2 support. HTTP/2 support is
                        enabled by default.

SSL:

  --certs SPEC          SSL certificates of the form "[domain=]path". The
                        domain may include a wildcard, and is equal to "*" if
                        not specified. The file at path is a certificate in
                        PEM format. If a private key is included in the PEM,
                        it is used, else the default key in the conf dir is
                        used. The PEM file should contain the full certificate
                        chain, with the leaf certificate as the first entry.
                        May be passed multiple times.
                        
  --cert-passphrase PASS
                        Passphrase for decrypting the private key provided in
                        the --cert option. Note that passing cert_passphrase
                        on the command line makes your passphrase visible in
                        your system\'s process list. Specify it in config.yaml
                        to avoid this.
                        
  --no-ssl-insecure
  --ssl-insecure, -k    Do not verify upstream server SSL/TLS certificates.


Client Replay:

  --client-replay PATH, -C PATH
                        Replay client requests from a saved file. May be
                        passed multiple times.


Server Replay:

  --server-replay PATH, -S PATH
                        Replay server responses from a saved file. May be
                        passed multiple times.
                        
  --no-server-replay-kill-extra
  --server-replay-kill-extra
                        Kill extra requests during replay (for which no
                        replayable response was found).
                        
  --no-server-replay-nopop
  --server-replay-nopop
                        Don\'t remove flows from server replay state after use.
                        This makes it possible to replay same response
                        multiple times.
                        
  --no-server-replay-refresh
  --server-replay-refresh
                        Refresh server replay responses by adjusting date,
                        expires and last-modified headers, as well as
                        adjusting cookie expiration.
                        

Map Remote:

  --map-remote PATTERN, -M PATTERN
                        Map remote resources to another remote URL using a
                        pattern of the form "[/flow-filter]/url-
                        regex/replacement", where the separator can be any
                        character. May be passed multiple times.
                        

Map Local:

  --map-local PATTERN   Map remote resources to a local file using a pattern
                        of the form "[/flow-filter]/url-regex/file-or-
                        directory-path", where the separator can be any
                        character. May be passed multiple times.


Modify Body:

  --modify-body PATTERN, -B PATTERN
                        Replacement pattern of the form "[/flow-
                        filter]/regex/[@]replacement", where the separator can
                        be any character. The @ allows to provide a file path
                        that is used to read the replacement string. May be
                        passed multiple times.


Modify Headers:

  --modify-headers PATTERN, -H PATTERN
                        Header modify pattern of the form "[/flow-
                        filter]/header-name/[@]header-value", where the
                        separator can be any character. The @ allows to
                        provide a file path that is used to read the header
                        value string. An empty header-value removes existing
                        header-name headers. May be passed multiple times.


Filters:
  See help in mitmproxy for filter expression syntax.

  --intercept FILTER    Intercept filter expression.
  
  --view-filter FILTER  Limit the view to matching flows.
                  
                    ）',
                    "command" => 'mitmproxy [options]',
                    "examples" => array(
                        array(
                            "title" => "",
                            "describe" => "使用指定网卡扫描192.168.1.0网段下的存活主机（当前C类网段最多可容纳254台主机）",
                            "command" => "netdiscover -i <网络接口名称> -r 192.168.1.0/24",
                        ),
                    ),
                ),
                "netsniff-ng" => array(
                    "title" => 'netsniff-ng : ',
                    "describe" => '网络包分析工具（
                    
Options:

  -i|-d|--dev|--in <dev|pcap|->  Input source as netdev, pcap or pcap stdin
  
  -o|--out <dev|pcap|dir|cfg|->  Output sink as netdev, pcap, directory, trafgen, or stdout
  
  -C|--fanout-group <id>         Join packet fanout group
  
  -K|--fanout-type <type>        Apply fanout discipline: hash|lb|cpu|rnd|roll|qm
  
  -L|--fanout-opts <opts>        Additional fanout options: defrag|roll
  
  -f|--filter <bpf-file|-|expr>  Use BPF filter from bpfc file/stdin or tcpdump-like expression
  
  -t|--type <type>               Filter for: host|broadcast|multicast|others|outgoing
  
  -F|--interval <size|time>      Dump interval if -o is a dir: <num>KiB/MiB/GiB/s/sec/min/hrs
  
  -R|--rfraw                     Capture or inject raw 802.11 frames
  
  -n|--num <0|uint>              Number of packets until exit (def: 0)
  
  -P|--prefix <name>             Prefix for pcaps stored in directory
  
  -O|--overwrite <N>             Limit the number of pcaps to N (file names use numbers 0 to N-1)
  
  -T|--magic <pcap-magic>        Pcap magic number/pcap format to store, see -D
  
  -w|--cooked                    Use Linux "cooked" header instead of link header
  
  -D|--dump-pcap-types           Dump pcap types and magic numbers and quit
  
  -B|--dump-bpf                  Dump generated BPF assembly
  
  -r|--rand                      Randomize packet forwarding order (dev->dev)
  
  -M|--no-promisc                No promiscuous mode for netdev
  
  -A|--no-sock-mem               Don\'t tune core socket memory
  
  -N|--no-hwtimestamp            Disable hardware time stamping
  
  -m|--mmap                      Mmap(2) pcap file I/O, e.g. for replaying pcaps
  
  -G|--sg                        Scatter/gather pcap file I/O
  
  -c|--clrw                      Use slower read(2)/write(2) I/O
  
  -S|--ring-size <size>          Specify ring size to: <num>KiB/MiB/GiB
  
  -k|--kernel-pull <uint>        Kernel pull from user interval in us (def: 10us)
  
  -J|--jumbo-support             Support replay/fwd 64KB Super Jumbo Frames (def: 2048B)
  
  -b|--bind-cpu <cpu>            Bind to specific CPU
  
  -u|--user <userid>             Drop privileges and change to userid
  
  -g|--group <groupid>           Drop privileges and change to groupid
  
  -H|--prio-high                 Make this high priority process
  
  -Q|--notouch-irq               Do not touch IRQ CPU affinity of NIC
  
  -s|--silent                    Do not print captured packets
  
  -q|--less                      Print less-verbose packet information
  
  -X|--hex                       Print packet data in hex format
  
  -l|--ascii                     Print human-readable packet data
  
  -U|--update                    Update GeoIP databases
  
  -V|--verbose                   Be more verbose
  
  -v|--version                   Show version and exit
  
  -h|--help                      Guess what?!


Note:
  For introducing bit errors, delays with random variation and more
  while replaying pcaps, make use of tc(8) with its disciplines (e.g. netem).

                    
                    ）',
                    "command" => 'netsniff-ng [options] [filter-expression]',
                    "examples" => array(
                        array(
                            "title" => "",
                            "describe" => "",
                            "command" => "netsniff-ng --in eth0 --out dump.pcap -s -T 0xa1b2c3d4 --bind-cpu 0 tcp or udp",
                        ),
                        array(
                            "title" => "",
                            "describe" => "",
                            "command" => "netsniff-ng --in wlan0 --rfraw --out dump.pcap --silent --bind-cpu 0",
                        ),
                        array(
                            "title" => "",
                            "describe" => "",
                            "command" => "netsniff-ng --in dump.pcap --mmap --out eth0 -k1000 --silent --bind-cpu 0",
                        ),
                        array(
                            "title" => "",
                            "describe" => "",
                            "command" => "netsniff-ng --in dump.pcap --out dump.cfg --silent --bind-cpu 0",
                        ),
                        array(
                            "title" => "",
                            "describe" => "",
                            "command" => "netsniff-ng --in dump.pcap --out dump2.pcap --silent tcp",
                        ),
                        array(
                            "title" => "",
                            "describe" => "",
                            "command" => "netsniff-ng --in eth0 --out eth1 --silent --bind-cpu 0 -J --type host",
                        ),
                        array(
                            "title" => "",
                            "describe" => "",
                            "command" => "netsniff-ng --in eth1 --out /opt/probe/ -s -m --interval 100MiB -b 0",
                        ),
                        array(
                            "title" => "",
                            "describe" => "",
                            "command" => "netsniff-ng --in vlan0 --out dump.pcap -c -u `id -u bob` -g `id -g bob",
                        ),
                        array(
                            "title" => "",
                            "describe" => "",
                            "command" => "netsniff-ng --in any --filter http.bpf --jumbo-support --ascii -V",
                        ),
                    ),
                ),
                "responder" => array(
                    "title" => 'responder : ',
                    "describe" => '嗅探/欺骗工具（
                    
Options:

  --version             show program\'s version number and exit
  
  -h, --help            show this help message and exit
  
  -A, --analyze         Analyze mode. This option allows you to see NBT-NS, BROWSER, LLMNR requests without responding.
  
  -I eth0, --interface=eth0   Network interface to use, you can use \'ALL\' as a wildcard for all interfaces
  
  -i 10.0.0.21, --ip=10.0.0.21    Local IP to use (only for OSX)
  
  -6 2002:c0a8:f7:1:3ba8:aceb:b1a9:81ed, --externalip6=2002:c0a8:f7:1:3ba8:aceb:b1a9:81ed   Poison all requests with another IPv6 address than Responder\'s one.
  
  -e 10.0.0.22, --externalip=10.0.0.22   Poison all requests with another IP address than Responder\'s one.
  
  -b, --basic           Return a Basic HTTP authentication. Default: NTLM
  
  -d, --DHCP            Enable answers for DHCP broadcast requests. This option will inject a WPAD server in the DHCP response. Default: False
  
  -D, --DHCP-DNS        This option will inject a DNS server in the DHCP response, otherwise a WPAD server will be added. Default: False
  
  -w, --wpad            Start the WPAD rogue proxy server. Default value is False
  
  -u UPSTREAM_PROXY, --upstream-proxy=UPSTREAM_PROXY Upstream HTTP proxy used by the rogue WPAD Proxy for outgoing requests (format: host:port)
                        
  -F, --ForceWpadAuth   Force NTLM/Basic authentication on wpad.dat file retrieval. This may cause a login prompt. Default:False
                        
  -P, --ProxyAuth       Force NTLM (transparently)/Basic (prompt) authentication for the proxy. WPAD doesn\'t need to be ON. This option is highly effective. Default: False
                        
  --lm                  Force LM hashing downgrade for Windows XP/2003 and earlier. Default: False
                        
  --disable-ess         Force ESS downgrade. Default: False
  
  -v, --verbose         Increase verbosity.

                    
                    ）',
                    "command" => 'responder -I eth0 -w -d',
                    "examples" => array(),
                ),
                "scapy" => array(
                    "title" => 'scapy : ',
                    "describe" => '强大的Python网络包解析库（
                    
使用示例：

//用rdpcap()函数导入PCAP文件，并读取其文件内容：

data = rdpcap("<指定的pcap文件>.pcap") 


//以打开方式获得文件句柄，采用迭代方式，循环地从指定的pcap文件中读取数据包内容（每次仅读取一个数据包的内容）

file_handle = open("<指定的pcap文件>.pcap", "rb") //以二进制只读方式打开指定的pcap文件

reader = PcapReader(file_handle) //获得文件的读取流对象

for data in reader: //循环从流中读取数据

    print(data) //打印出读取到的数据

file_handle.close() //关闭文件句柄


//模糊测试

send(IP(dst="<指定的IP地址>")/fuzz(UDP()/NTP(version=4)),loop=1) //对指定IP地址对应的主机目标进行模糊测试（针对UDP和NTP协议进行测试）
                    
                    ）',
                    "command" => 'scapy',
                    "examples" => array(),
                ),
                "tcpdump" => array(
                    "title" => 'tcpdump : ',
                    "describe" => '非常好用的LINUX环境下的抓包工具（
                    
参数选项：

　　　-a 　　　将网络地址与广播地址转变成网络名称；

　　　-d 　　　将匹配的数据包相关内容以人类可以理解的方式进行输出（如：汇编格式）；

　　　-dd 　　 将匹配的数据包相关内容以C语言代码的格式进行输出；

　　　-ddd 　　将匹配的数据包相关以十进制的格式进行输出；

　　　-e 　　　在输出内容中打印出数据链路层的头部信息（包括源网卡地址（source mac address）和目的网卡地址（destination mac address），以及网络层的协议类型（IPV4/IPV6等））；

　　　-f 　　　将IP地址以数字的形式打印出来；

　　　-l 　　　将标准输出变改为缓冲形式；

　　　-n 　　　将监听到的数据包中的域名转换为IP地址（不将网络地址转换成网络名称）；

     -nn：    将监听到的数据包中的域名转换为IP地址，将应用程序名称转换为端口号；

　　　-t 　　　不输出时间戳信息；

　　　-v 　　　输出较为详细的信息（例如,在IP协议的数据包中，包括生存跃点数（TTL）和服务类型等信息）；

　　　-vv 　　 输出详细的数据包信息；

　　　-c 　　　在接收到指定数量的指定类型协议的数据包之后，tcpdump将停止工作；

　　　-F 　　　从指定的文件中读取表达式（忽略其它的表达式）；

　　　-i 　　　指定监听的网络接口（网卡名称）；

     -p：    将网卡设置为非混杂模式（不能与host或broadcast等方式一起使用）

　　　-r 　　　从指定的文件中读取数据包信息(文件中的数据包，一般是通过 -w 选项写入到指定文件中的 )；

　　　-w 　　　直接将数据包写入到文件中（不进行数据包分析和打印操作）；

     -s snaplen 　　　设定从一个包中截取的字节数（0=不截断，使用完整的数据包；默认值：68个字节（只截取部分的数据包内容））； 

　　　-T 　　  将监听到的数据包翻译为指定类型的数据包（常见的数据类型，包括rpc（远程过程调用）和snmp（简单网络管理协议））；

     -X      将数据包协议头部分和数据包内容部分均进行原样输出（以16进制格式 + ASCII格式的方式进行内容输出）（在进行协议分析操作时，会经常用到！）
                    
                    ）',
                    "command" => 'tcpdump [-AbdDefhHIJKlLnNOpqStuUvxX#] [ -B size ] [ -c count ] [--count] [ -C file_size ] [ -E algo:secret ] [ -F file ] [ -G seconds ] [ -i interface ] [ --immediate-mode ] [ -j tstamptype ] [ -M secret ] [ --number ] [ --print ] [ -Q in|out|inout ] [ -r file ] [ -s snaplen ] [ -T type ] [ --version ] [ -V file ] [ -w file ] [ -W filecount ] [ -y datalinktype ] [ --time-stamp-precision precision ] [ --micro ] [ --nano ] [ -z postrotate-command ] [ -Z user ] [ expression ]',
                    "examples" => array(),
                ),
                "wireshark" => array(
                    "title" => 'wireshark : ',
                    "describe" => '一款强大的可视化抓包工具',
                    "command" => 'wireshark',
                    "examples" => array(),
                ),
            ),
        );
        Class_Base_Auth::check_permission();
        if (!is_cli()) {
            $_form_top = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Sniff Deception Commands</div>';
            $_form = array(
                "action" => "/guide/penetration_test_commands",
                "inputs" => array(),
                "textareas" => array(),
                "submit" => array(
                    "value" => " return to Penetration Test Commands ",
                    "display" => true,
                ),
                "reset" => array(
                    "display" => false,
                ),
            );
            self::_commands_format_to_form_textareas($_common_commands, $_form);
            $_top = Class_View_Top::top();
            $_body = array(
                "menu" => Class_View_Guide_PenetrationTestCommands_Menu::menu(),
                "content" => (($_form_top) . Class_View::form_body($_form)),
            );
            $_bottom = Class_View_Bottom::bottom();
            Class_Base_Response::output(Class_View::index($_top, $_body, $_bottom), "text", 0);
        }
        return null;
    }

    public static function permission_maintenance($params = array())
    {
        if ((!is_cli()) && (!Class_Base_Auth::is_login())) {
            Class_Base_Response::redirect("/login");
            return null;
        }
        $_common_commands = array(
            "permission_maintenance" => array(
                "evil-winrm" => array(
                    "title" => 'evil-winrm : ',
                    "describe" => '远程渗透管理工具（
                    
Options:

    -S, --ssl                        Enable ssl
    
    -c, --pub-key PUBLIC_KEY_PATH    Local path to public key certificate
    
    -k, --priv-key PRIVATE_KEY_PATH  Local path to private key certificate
    
    -r, --realm DOMAIN               Kerberos auth, it has to be set also in /etc/krb5.conf file using this format -> CONTOSO.COM = { kdc = fooserver.contoso.com }
    
    -s, --scripts PS_SCRIPTS_PATH    Powershell scripts local path
    
        --spn SPN_PREFIX             SPN prefix for Kerberos auth (default HTTP)
        
    -e, --executables EXES_PATH      C# executables local path
    
    -i, --ip IP                      Remote host IP or hostname. FQDN for Kerberos auth (required)
    
    -U, --url URL                    Remote url endpoint (default /wsman)
    
    -u, --user USER                  Username (required if not using kerberos)
    
    -p, --password PASS              Password
    
    -H, --hash HASH                  NTHash
    
    -P, --port PORT                  Remote host port (default 5985)
    
    -V, --version                    Show version
    
    -n, --no-colors                  Disable colors
    
    -N, --no-rpath-completion        Disable remote path completion
    
    -l, --log                        Log the WinRM session
    
    -h, --help                       Display this help message                    
                    
                    ）',
                    "command" => 'evil-winrm -i IP -u USER [-s SCRIPTS_PATH] [-e EXES_PATH] [-P PORT] [-p PASS] [-H HASH] [-U URL] [-S] [-c PUBLIC_KEY_PATH ] [-k PRIVATE_KEY_PATH ] [-r REALM] [--spn SPN_PREFIX] [-l]',
                    "examples" => array(),
                ),
                "exe2hex" => array(
                    "title" => 'exe2hex : ',
                    "describe" => '二进制文件内容格式转换工具（
                    
Options:

  -h, --help  show this help message and exit
  
  -x EXE      The EXE binary file to convert
  
  -s          Read from STDIN
  
  -b BAT      BAT output file (DEBUG.exe method - x86)
  
  -p POSH     PoSh output file (PowerShell method - x86/x64)
  
  -e          URL encode the output
  
  -r TEXT     pRefix - text to add before the command on each line
  
  -f TEXT     suFfix - text to add after the command on each line
  
  -l INT      Maximum HEX values per line
  
  -c          Clones and compress the file before converting (-cc for higher compression)
  
  -t          Create a Expect file, to automate to a Telnet session.
  
  -w          Create a Expect file, to automate to a WinEXE session.
  
  -v          Enable verbose mode
                    
                    ）',
                    "command" => 'exe2hex [options]',
                    "examples" => array(),
                ),
                "impacket" => array(
                    "title" => 'impacket : ',
                    "describe" => '域渗透工具包（
                    
$ (cd /usr/bin/ && ls --color=auto impacket-*)

impacket-addcomputer      impacket-lookupsid          impacket-rpcmap
impacket-atexec           impacket-machine_role       impacket-sambaPipe
impacket-dcomexec         impacket-mimikatz           impacket-samrdump
impacket-dpapi            impacket-mqtt_check         impacket-secretsdump
impacket-esentutl         impacket-mssqlclient        impacket-services
impacket-exchanger        impacket-mssqlinstance      impacket-smbclient
impacket-findDelegation   impacket-netview            impacket-smbexec
impacket-GetADUsers       impacket-nmapAnswerMachine  impacket-smbpasswd
impacket-getArch          impacket-ntfs-read          impacket-smbrelayx
impacket-Get-GPPPassword  impacket-ntlmrelayx         impacket-smbserver
impacket-GetNPUsers       impacket-ping               impacket-sniff
impacket-getPac           impacket-ping6              impacket-sniffer
impacket-getST            impacket-psexec             impacket-split
impacket-getTGT           impacket-raiseChild         impacket-ticketConverter
impacket-GetUserSPNs      impacket-rbcd               impacket-ticketer
impacket-goldenPac        impacket-rdp_check          impacket-wmiexec
impacket-karmaSMB         impacket-reg                impacket-wmipersist
impacket-keylistattack    impacket-registry-read      impacket-wmiquery
impacket-kintercept       impacket-rpcdump
                    
                    ）',
                    "command" => '(cd /usr/bin/ && ls --color=auto impacket-*)',
                    "examples" => array(),
                ),
                "mimikatz" => array(
                    "title" => 'mimikatz : ',
                    "describe" => '系统密码解密工具（
                    
> mimikatz ~ Uses admin rights on Windows to display passwords in plaintext

/usr/share/windows-resources/mimikatz
├── kiwi_passwords.yar
├── mimicom.idl
├── Win32
│   ├── mimidrv.sys
│   ├── mimikatz.exe
│   ├── mimilib.dll
│   ├── mimilove.exe
│   └── mimispool.dll
└── x64
    ├── mimidrv.sys
    ├── mimikatz.exe
    ├── mimilib.dll
    └── mimispool.dll
                    
                    ）',
                    "command" => 'mimikatz',
                    "examples" => array(),
                ),
                "netcat" => array(
                    "title" => 'netcat : ',
                    "describe" => '网络测试工具（使用UDP和TCP协议）（
                    
connect to somewhere:	nc [-options] hostname port[s] [ports] ... 
listen for inbound:	nc -l -p port [-options] [hostname] [port]

options:

	-c shell commands	as `-e\'; use /bin/sh to exec [dangerous!!]
	-e filename		program to exec after connect [dangerous!!]
	-b			allow broadcasts
	-g gateway		source-routing hop point[s], up to 8
	-G num			source-routing pointer: 4, 8, 12, ...
	-h			this cruft
	-i secs			delay interval for lines sent, ports scanned
        -k                      set keepalive option on socket
	-l			listen mode, for inbound connects
	-n			numeric-only IP addresses, no DNS
	-o file			hex dump of traffic
	-p port			local port number
	-r			randomize local and remote ports
	-q secs			quit after EOF on stdin and delay of secs
	-s addr			local source address
	-T tos			set Type Of Service
	-t			answer TELNET negotiation
	-u			UDP mode
	-v			verbose [use twice to be more verbose]
	-w secs			timeout for connects and final net reads
	-C			Send CRLF as line-ending
	-z			zero-I/O mode [used for scanning]
	
port numbers can be individual or ranges: lo-hi [inclusive];
hyphens in port names must be backslash escaped (e.g. \'ftp\-data\').

                    ）',
                    "command" => 'netcat -h',
                    "examples" => array(),
                ),
                "powershell-empire" => array(
                    "title" => 'powershell-empire : ',
                    "describe" => '后渗透利用工具（
                    
positional arguments:

  {server,client}
    server         Launch Empire Server
    client         Launch Empire CLI

options:

  -h, --help       show this help message and exit
  

agents            Jump to the Agents menu. （跳转到“代理”菜单） 

creds             Add/display credentials to/from the database. （向数据库添加/显示凭据）

exit              Exit Empire. （退出软件）

help              Displays the help menu. （显示帮助菜单）

interact          Interact with a particular agent. （与特定代理交互）

list              Lists active agents or listeners. （列出活动代理或侦听器）

listeners         Interact with active listeners. （与活跃的听众互动）

load              Loads Empire modules from a non-standard folder. （从非标准文件夹加载Empire模块）

plugin            Load a plugin file to extend Empire. （加载插件文件以扩展Empire ）

plugins           List all available and active plugins. （列出所有可用和活动的插件）

preobfuscate      Preobfuscate PowerShell module_source files. （预启动PowerShell模块源文件）

reload            Reload one (or all) Empire modules. （重新加载一个（或所有）Empire模块）

report            Produce report CSV and log files: sessions.csv, credentials.csv,  生成报告CSV和日志文件：sessions.CSV、credentials.CSV

reset             Reset a global option (e.g. IP whitelists). （重置全局选项（例如IP白名单） ）

resource          Read and execute a list of Empire commands from a file. （从文件中读取并执行Empire命令列表 ）

searchmodule      Search Empire module names/descriptions. （搜索Empire模块名称/描述）

set               Set a global option (e.g. IP whitelists). （设置全局选项（例如IP白名单））

show              Show a global option (e.g. IP whitelists). （显示全局选项（例如IP白名单））

usemodule         Use an Empire module. （使用Empire模块）

usestager         Use an Empire stager. （使用Empire舞台）
                    
                    ）',
                    "command" => 'empire.py [-h] {server,client} ...',
                    "examples" => array(
                        array(
                            "title" => "",
                            "describe" => "开启powershell-empire服务",
                            "command" => "powershell-empire server",
                        ),
                        array(
                            "title" => "",
                            "describe" => "启动客户端",
                            "command" => "powershell-empire client",
                        ),
                    ),
                ),
                "powersploit" => array(
                    "title" => 'powersploit : ',
                    "describe" => '基于PowerShell的后渗透框架软件（
                    
/usr/share/windows-resources/powersploit

├── AntivirusBypass
├── CodeExecution
├── Exfiltration
├── Mayhem
├── Persistence
├── PowerSploit.psd1
├── PowerSploit.psm1
├── Privesc
├── README.md
├── Recon
├── ScriptModification
└── Tests               
                    
                    ）',
                    "command" => 'powersploit',
                    "examples" => array(),
                ),
                "proxychains4" => array(
                    "title" => 'proxychains4 : ',
                    "describe" => '强制应用的TCP连接通过代理的工具（
                    
Options:

    -q makes proxychains quiet - this overrides the config setting
    
	-f allows one to manually specify a configfile to use for example : proxychains telnet somehost.com
	
More help in README file
                    
                    ）',
                    "command" => 'proxychains4 -q -f config_file program_name [arguments]',
                    "examples" => array(),
                ),
                "weevely" => array(
                    "title" => 'weevely : ',
                    "describe" => '基于python编写的webshell管理工具（
                    
positional arguments:
  url         The agent URL
  password    The agent password
  cmd         Command

options:
  -h, --help  show this help message and exit
                    
                    ）',
                    "command" => 'weevely terminal [-h] url password [cmd]',
                    "examples" => array(),
                ),
            ),
        );
        Class_Base_Auth::check_permission();
        if (!is_cli()) {
            $_form_top = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Permission Maintenance Commands</div>';
            $_form = array(
                "action" => "/guide/penetration_test_commands",
                "inputs" => array(),
                "textareas" => array(),
                "submit" => array(
                    "value" => " return to Penetration Test Commands ",
                    "display" => true,
                ),
                "reset" => array(
                    "display" => false,
                ),
            );
            self::_commands_format_to_form_textareas($_common_commands, $_form);
            $_top = Class_View_Top::top();
            $_body = array(
                "menu" => Class_View_Guide_PenetrationTestCommands_Menu::menu(),
                "content" => (($_form_top) . Class_View::form_body($_form)),
            );
            $_bottom = Class_View_Bottom::bottom();
            Class_Base_Response::output(Class_View::index($_top, $_body, $_bottom), "text", 0);
        }
        return null;
    }

    public static function data_forensics($params = array())
    {
        if ((!is_cli()) && (!Class_Base_Auth::is_login())) {
            Class_Base_Response::redirect("/login");
            return null;
        }
        $_common_commands = array(
            "data_forensics" => array(
                "autopsy(root)" => array(
                    "title" => 'autopsy ( root ) : ',
                    "describe" => '数字取证工具（Web界面，默认监听9999端口）',
                    "command" => 'autopsy',
                    "examples" => array(),
                ),
                "binwalk" => array(
                    "title" => 'binwalk : ',
                    "describe" => '一款快速、易用，用于分析，逆向工程和提取固件映像的工具（
                    
Signature Scan Options:

    -B, --signature              Scan target file(s) for common file signatures
    
    -R, --raw=<str>              Scan target file(s) for the specified sequence of bytes
    
    -A, --opcodes                Scan target file(s) for common executable opcode signatures
    
    -m, --magic=<file>           Specify a custom magic file to use
    
    -b, --dumb                   Disable smart signature keywords
    
    -I, --invalid                Show results marked as invalid
    
    -x, --exclude=<str>          Exclude results that match <str>
    
    -y, --include=<str>          Only show results that match <str>
    

Extraction Options:

    -e, --extract                Automatically extract known file types
    
    -D, --dd=<type[:ext[:cmd]]>  Extract <type> signatures (regular expression), give the files an extension of <ext>, and execute <cmd>
    
    -M, --matryoshka             Recursively scan extracted files
    
    -d, --depth=<int>            Limit matryoshka recursion depth (default: 8 levels deep)
    
    -C, --directory=<str>        Extract files/folders to a custom directory (default: current working directory)
    
    -j, --size=<int>             Limit the size of each extracted file
    
    -n, --count=<int>            Limit the number of extracted files
    
    -0, --run-as=<str>           Execute external extraction utilities with the specified user\'s privileges
    
    -1, --preserve-symlinks      Do not sanitize extracted symlinks that point outside the extraction directory (dangerous)
    
    -r, --rm                     Delete carved files after extraction
    
    -z, --carve                  Carve data from files, but don\'t execute extraction utilities
    
    -V, --subdirs                Extract into sub-directories named by the offset
    

Entropy Options:

    -E, --entropy                Calculate file entropy
    
    -F, --fast                   Use faster, but less detailed, entropy analysis
    
    -J, --save                   Save plot as a PNG
    
    -Q, --nlegend                Omit the legend from the entropy plot graph
    
    -N, --nplot                  Do not generate an entropy plot graph
    
    -H, --high=<float>           Set the rising edge entropy trigger threshold (default: 0.95)
    
    -L, --low=<float>            Set the falling edge entropy trigger threshold (default: 0.85)
    

Binary Diffing Options:

    -W, --hexdump                Perform a hexdump / diff of a file or files
    
    -G, --green                  Only show lines containing bytes that are the same among all files
    
    -i, --red                    Only show lines containing bytes that are different among all files
    
    -U, --blue                   Only show lines containing bytes that are different among some files
    
    -u, --similar                Only display lines that are the same between all files
    
    -w, --terse                  Diff all files, but only display a hex dump of the first file
    

Raw Compression Options:

    -X, --deflate                Scan for raw deflate compression streams
    
    -Z, --lzma                   Scan for raw LZMA compression streams
    
    -P, --partial                Perform a superficial, but faster, scan
    
    -S, --stop                   Stop after the first result
    

General Options:

    -l, --length=<int>           Number of bytes to scan
    
    -o, --offset=<int>           Start scan at this file offset
    
    -O, --base=<int>             Add a base address to all printed offsets
    
    -K, --block=<int>            Set file block size
    
    -g, --swap=<int>             Reverse every n bytes before scanning
    
    -f, --log=<file>             Log results to file
    
    -c, --csv                    Log results to file in CSV format
    
    -t, --term                   Format output to fit the terminal window
    
    -q, --quiet                  Suppress output to stdout
    
    -v, --verbose                Enable verbose output
    
    -h, --help                   Show help output
    
    -a, --finclude=<str>         Only scan files whose names match this regex
    
    -p, --fexclude=<str>         Do not scan files whose names match this regex
    
    -s, --status=<int>           Enable the status server on the specified port

                    ）',
                    "command" => 'binwalk [OPTIONS] [FILE1] [FILE2] [FILE3] ...',
                    "examples" => array(),
                ),
                "bulk_extractor" => array(
                    "title" => 'bulk_extractor : ',
                    "describe" => '一款从数字证据文件中提取相应取证信息（诸如，电子邮件地址、信用卡号、URL、以及其他类型信息等）的工具软件（
                    
Options:

  -A, --offset_add arg            Offset added (in bytes) to feature locations (default: 0)
  
  -b, --banner_file arg           Path of file whose contents are prepended to top of all feature files
  
  -C, --context_window arg        Size of context window reported in bytes (default: 16)
  
  -d, --debug arg                 enable debugging (default: 1)
  
  -D, --debug_help                help on debugging
  
  -E, --enable_exclusive arg      disable all scanners except the one specified.  Same as -x all -E scanner.
  
  -e, --enable arg                enable a scanner (can be repeated)
  
  -x, --disable arg               disable a scanner (can be repeated)
  
  -f, --find arg                  search for a pattern (can be repeated)
  
  -F, --find_file arg             read patterns to search from a file (can be repeated)
  
  -G, --pagesize arg              page size in bytes (default: 16777216)
  
  -g, --marginsize arg            margin size in bytes (default: 4194304)
  
  -j, --threads arg               number of threads (default: 4)
  
  -J, --no_threads                read and process data in the primary thread
  
  -M, --max_depth arg             max recursion depth (default: 12)
  
      --max_bad_alloc_errors arg  max bad allocation errors (default: 3)
      
      --max_minute_wait arg       maximum number of minutes to wait until all data are read (default: 60)
      
      --notify_main_thread      Display notifications in the main thread after phase1 completes. Useful for running with ThreadSanitizer
      
      --notify_async            Display notificaitons asynchronously (default)
      
  -o, --outdir arg              output directory [REQUIRED]
  
  -P, --scanner_dir arg         directories for scanner shared libraries (can be repeated). Default directories include /usr/local/lib/bulk_extractor,  /usr/lib/bulk_extractor and any directories specified in the BE_PATH environment variable.
  
  -p, --path arg                print the value of <path>[:length][/h][/r] with optional length, hex output, or raw output.
  
  -q, --quit                    no status or performance output
  
  -r, --alert_list arg          file to read alert list from
  
  -R, --recurse                 treat image file as a directory to recursively explore
  
  -S, --set arg                 set a name=value option (can be repeated)
  
  -s, --sampling arg            random sampling parameter frac[:passes]
  
  -V, --version                 Display PACKAGE_VERSION (currently) 2.0.0
  
  -w, --stop_list arg           file to read stop list from
  
  -Y, --scan arg                specify <start>[-end] of area on disk to scan
  
  -z, --page_start arg          specify a starting page number
  
  -Z, --zap                     wipe the output directory (recursively) before starting
  
  -0, --no_notify               disable real-time notification
  
  -1, --version1                version 1.0 notification (console-output)
  
  -H, --info_scanners           report information about each scanner
  
  -h, --help                    print help screen
  

Global config options: 

   -S notify_rate=1    seconds between notificaiton update (notify_rate)
   
   -S debug_histogram_malloc_fail_frequency=0    Set >0 to make histogram maker fail with memory allocations (debug_histogram_malloc_fail_frequency)
   
   -S hash_alg=sha1    Specifies hash algorithm to be used for all hash calculations (hash_alg)
   
   -S report_read_errors=1    Report read errors (report_read_errors)
   

These scanners enabled; disable with -x:

   -x accts - disable scanner accts
     -S ssn_mode=0    0=Normal; 1=No `SSN\' required; 2=No dashes required
     -S min_phone_digits=7    Min. digits required in a phone
     
   -x aes - disable scanner aes
     -S scan_aes_128=1    Scan for 128-bit AES keys; 0=No, 1=Yes
     -S scan_aes_192=0    Scan for 192-bit AES keys; 0=No, 1=Yes
     -S scan_aes_256=1    Scan for 256-bit AES keys; 0=No, 1=Yes
     
   -x base64 - disable scanner base64
   
   -x elf - disable scanner elf
   
   -x email - disable scanner email
   
   -x evtx - disable scanner evtx
   
   -x exif - disable scanner exif
   
     -S exif_debug=0    debug exif decoder
     
   -x facebook - disable scanner facebook
   
   -x find - disable scanner find
   
   -x gps - disable scanner gps
   
   -x gzip - disable scanner gzip
     -S gzip_max_uncompr_size=268435456    maximum size for decompressing GZIP objects
     
   -x httplogs - disable scanner httplogs
   
   -x json - disable scanner json
   
   -x kml_carved - disable scanner kml_carved
   
   -x msxml - disable scanner msxml
   
   -x net - disable scanner net
     -S carve_net_memory=0    Carve network  memory structures
     -S min_carve_packet_bytes=40    Smallest network packet to carve
     
   -x ntfsindx - disable scanner ntfsindx
   
   -x ntfslogfile - disable scanner ntfslogfile
   
   -x ntfsmft - disable scanner ntfsmft
   
   -x ntfsusn - disable scanner ntfsusn
   
   -x pdf - disable scanner pdf
     -S pdf_dump_hex=0    Dump the contents of PDF buffers as hex
     -S pdf_dump_text=0    Dump the contents of PDF buffers showing extracted text
     
   -x rar - disable scanner rar
     -S rar_find_components=1    Search for RAR components
     -S rar_find_volumes=1    Search for RAR volumes
     
   -x sqlite - disable scanner sqlite
   
   -x utmp - disable scanner utmp
   
   -x vcard_carved - disable scanner vcard_carved
   
   -x windirs - disable scanner windirs
     -S opt_weird_file_size=157286400    Threshold for FAT32 scanner
     -S opt_weird_file_size2=536870912    Threshold for FAT32 scanner
     -S opt_weird_cluster_count=67108864    Threshold for FAT32 scanner
     -S opt_weird_cluster_count2=268435456    Threshold for FAT32 scanner
     -S opt_max_bits_in_attrib=3    Ignore FAT32 entries with more attributes set than this
     -S opt_max_weird_count=2    Number of \'weird\' counts to ignore a FAT32 entry
     -S opt_last_year=2028    Ignore FAT32 entries with a later year than this
     
   -x winlnk - disable scanner winlnk
   
   -x winpe - disable scanner winpe
   
   -x winprefetch - disable scanner winprefetch
   
   -x zip - disable scanner zip
     -S zip_min_uncompr_size=6    Minimum size of a ZIP uncompressed object
     -S zip_max_uncompr_size=268435456    Maximum size of a ZIP uncompressed object
     -S zip_name_len_max=1024    Maximum name of a ZIP component filename
     
     
These scanners disabled; enable with -e:

   -e base16 - enable scanner base16
   
   -e hiberfile - enable scanner hiberfile
   
   -e outlook - enable scanner outlook
   
   -e wordlist - enable scanner wordlist
     -S word_min=6    Minimum word size
     -S word_max=16    Maximum word size
     -S max_output_file_size=100000000    Maximum size of the words output file
     -S strings=0    Scan for strings instead of words
     
   -e xor - enable scanner xor
     -S xor_mask=255    XOR mask value, in decimal
                    
                    ）',
                    "command" => 'bulk_extractor [OPTION...] image_name',
                    "examples" => array(),
                ),
                "hashdeep" => array(
                    "title" => 'hashdeep : ',
                    "describe" => '文件完整性检测工具（
                    
Options:

-c <alg1,[alg2]> - Compute hashes only. Defaults are MD5 and SHA-256 legal values: md5,sha1,sha256,tiger,whirlpool,

-p <size> - piecewise mode. Files are broken into blocks for hashing

-r        - recursive mode. All subdirectories are traversed

-d        - output in DFXML (Digital Forensics XML)

-k <file> - add a file of known hashes

-a        - audit mode. Validates FILES against known hashes. Requires -k

-m        - matching mode. Requires -k

-x        - negative matching mode. Requires -k

-w        - in -m mode, displays which known file was matched

-M and -X act like -m and -x, but display hashes of matching files

-e        - compute estimated time remaining for each file

-s        - silent mode. Suppress all error messages

-b        - prints only the bare name of files; all path information is omitted

-l        - print relative paths for filenames

-i/-I     - only process files smaller than the given threshold

-o        - only process certain types of files. See README/manpage

-v        - verbose mode. Use again to be more verbose

-d        - output in DFXML; -W FILE - write to FILE.

-j <num>  - use num threads (default 4)
     
                    ）',
                    "command" => 'hashdeep [OPTION]... [FILES]...',
                    "examples" => array(),
                ),
            ),
        );
        Class_Base_Auth::check_permission();
        if (!is_cli()) {
            $_form_top = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Data Forensics Commands</div>';
            $_form = array(
                "action" => "/guide/penetration_test_commands",
                "inputs" => array(),
                "textareas" => array(),
                "submit" => array(
                    "value" => " return to Penetration Test Commands ",
                    "display" => true,
                ),
                "reset" => array(
                    "display" => false,
                ),
            );
            self::_commands_format_to_form_textareas($_common_commands, $_form);
            $_top = Class_View_Top::top();
            $_body = array(
                "menu" => Class_View_Guide_PenetrationTestCommands_Menu::menu(),
                "content" => (($_form_top) . Class_View::form_body($_form)),
            );
            $_bottom = Class_View_Bottom::bottom();
            Class_Base_Response::output(Class_View::index($_top, $_body, $_bottom), "text", 0);
        }
        return null;
    }

    public static function reporting($params = array())
    {
        if ((!is_cli()) && (!Class_Base_Auth::is_login())) {
            Class_Base_Response::redirect("/login");
            return null;
        }
        $_common_commands = array(
            "reporting" => array(
                "cherrytree" => array(
                    "title" => 'CherryTree : ',
                    "describe" => '一款支持无限层级分类的笔记软件（采用 Python 语言编写，支持富文本编辑与代码高亮模式，支持 Linux、Windows 等平台）',
                    "command" => 'cherrytree',
                    "examples" => array(),
                ),
                "cutycapt" => array(
                    "title" => 'cutycapt : ',
                    "describe" => '网页截图工具（
      
Options:
                    
  --help                         Print this help page and exit 
                 
  --url=<url>                    The URL to capture (http:...|file:...|...)   
  
  --out=<path>                   The target file (.png|pdf|ps|svg|jpeg|...)   
  
  --out-format=<f>               Like extension in --out, overrides heuristic 
  
  --min-width=<int>              Minimal width for the image (default: 800)   
  
  --min-height=<int>             Minimal height for the image (default: 600)  
  
  --max-wait=<ms>                Don\'t wait more than (default: 90000, inf: 0)
  
  --delay=<ms>                   After successful load, wait (default: 0)   
    
  --user-style-path=<path>       Location of user style sheet file, if any    
  
  --user-style-string=<css>      User style rules specified as text          
   
  --header=<name>:<value>        request header; repeatable; some can\'t be set
  
  --method=<get|post|put>        Specifies the request method (default: get)  
  
  --body-string=<string>         Unencoded request body (default: none)      
   
  --body-base64=<base64>         Base64-encoded request body (default: none)  
  
  --app-name=<name>              appName used in User-Agent; default is none  
  
  --app-version=<version>        appVers used in User-Agent; default is none  
  
  --user-agent=<string>          Override the User-Agent header Qt would set 
   
  --javascript=<on|off>          JavaScript execution (default: on)     
        
  --java=<on|off>                Java execution (default: unknown)    
          
  --plugins=<on|off>             Plugin execution (default: unknown)  
          
  --private-browsing=<on|off>    Private browsing (default: unknown)   
         
  --auto-load-images=<on|off>    Automatic image loading (default: on)   
       
  --js-can-open-windows=<on|off> Script can open windows? (default: unknown)  
  
  --js-can-access-clipboard=<on|off> Script clipboard privs (default: unknown)
  
  --print-backgrounds=<on|off>   Backgrounds in PDF/PS output (default: off)  
  
  --zoom-factor=<float>          Page zoom factor (default: no zooming)      
   
  --zoom-text-only=<on|off>      Whether to zoom only the text (default: off) 
  
  --http-proxy=<url>             Address for HTTP proxy server (default: none)
  
  --smooth                       Attempt to enable Qt\'s high-quality settings.
  
  --insecure                     Ignore SSL/TLS certificate errors       
       
       
 -----------------------------------------------------------------------------
  <f> is svg,ps,pdf,itext,html,rtree,png,jpeg,mng,tiff,gif,bmp,ppm,xbm,xpm 
     
     
 -----------------------------------------------------------------------------
 http://cutycapt.sf.net - (c) 2003-2013 Bjoern Hoehrmann - bjoern@hoehrmann.de
                    
                    ）',
                    "command" => 'CutyCapt --url=<url> --out=<image save path> ',
                    "examples" => array(),
                ),
                "faraday" => array(
                    "title" => 'faraday : ',
                    "describe" => '渗透测试IDE和漏洞管理平台（Web界面，默认监听端口为5985）',
                    "command" => 'faraday',
                    "examples" => array(
                        array(
                            "title" => "",
                            "describe" => "重置密码",
                            "command" => "faraday-manage change-password",
                        ),
                    ),
                ),
                "maltego" => array(
                    "title" => 'maltego : ',
                    "describe" => '网络空间情报分析工具（图形化界面）',
                    "command" => 'maltego',
                    "examples" => array(),
                ),
                "pipal" => array(
                    "title" => 'pipal : ',
                    "describe" => '密码统计分析工具（
                    
Options:

	--help, -h, -?: show help
	
	--top, -t X: show the top X results (default 10)
	
	--output, -o <filename>: output to file
	
	--gkey <Google Maps API key>: to allow zip code lookups (optional)
	
	--list-checkers: Show the available checkers and which are enabled
	
	--verbose, -v: Verbose


	FILENAME: The file to count
	             
                    ）',
                    "command" => 'pipal [OPTION] ... FILENAME',
                    "examples" => array(),
                ),
                "recordmydesktop" => array(
                    "title" => 'recordmydesktop : ',
                    "describe" => '屏幕录像工具（
                    
Generic Options

  -h, --help                              Print this help and exit.
  
      --version                           Print program version and exit.
      
      --print-config                      Print info about options selected during compilation and exit.


Image Options

      --windowid=id_of_window             id of window to be recorded.
      
      --display=DISPLAY                   Display to connect to.
      
  -x, --x=N>=0                            Offset in x direction.
  
  -y, --y=N>=0                            Offset in y direction.
  
      --width=N>0                         Width of recorded window.
      
      --height=N>0                        Height of recorded window.
      
      --dummy-cursor=color                Color of the dummy cursor [black|white]
      
      --no-cursor                         Disable drawing of the cursor.
      
      --no-shared                         Disable usage of MIT-shared memory extension(Not Recommended!).
      
      --full-shots                        Take full screenshot at every frame(Not recomended!).
      
      --follow-mouse                      Makes the capture area follow the mouse cursor. Autoenables --full-shots.
      
      --quick-subsampling                 Do subsampling of the chroma planes by discarding, not averaging.
      
      --fps=N(number>0.0)                 A positive number denoting desired framerate.


Sound Options

      --channels=N                        A positive number denoting desired sound channels in recording.
      
      --freq=N                            A positive number denoting desired sound frequency.
      
      --buffer-size=N                     A positive number denoting the desired sound buffer size (in frames,when using ALSA or OSS)
      
      --ring-buffer-size=N                A float number denoting the desired ring buffer size (in seconds,when using JACK only).
      
      --device=SOUND_DEVICE               Sound device(default default).
      
      --use-jack=port1 port2... portn     Record audio from the specified list of space-separated jack ports.
      
      --no-sound                          Do not record sound.


Encoding Options

      --on-the-fly-encoding               Encode the audio-video data, while recording.
      
      --v_quality=n                       A number from 0 to 63 for desired encoded video quality(default 63).
      
      --v_bitrate=n                       A number from 0 to 200000000 for desired encoded video bitrate(default 0).
      
      --s_quality=n                       Desired audio quality(-1 to 10).


Misc Options

      --rescue=path_to_data               Encode data from a previous, crashed, session.
      
      --no-wm-check                       Do not try to detect the window manager(and set options according to it)
      
      --no-frame                          Don not show the frame that visualizes the recorded area.
      
      --pause-shortcut=MOD+KEY            Shortcut that will be used for (un)pausing (default Control+Mod1+p).
      
      --stop-shortcut=MOD+KEY             Shortcut that will be used to stop the recording (default Control+Mod1+s).
      
      --compress-cache                    Image data are cached with light compression.
      
      --workdir=DIR                       Location where a temporary directory will be created to hold project files(default $HOME).
      
      --delay=n[H|h|M|m]                  Number of secs(default),minutes or hours before capture starts(number can be float)
      
      --overwrite                         If there is already a file with the same name, delete it (default is to add a number postfix to the new one).
      
  -o, --output=filename                   Name of recorded video(defaultout.ogv).


	If no other options are specified, filename can be given without the -o switch.
                   
                    ）',
                    "command" => 'recordmydesktop [OPTIONS]^filename',
                    "examples" => array(),
                ),
            ),
        );
        Class_Base_Auth::check_permission();
        if (!is_cli()) {
            $_form_top = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Reporting Commands</div>';
            $_form = array(
                "action" => "/guide/penetration_test_commands",
                "inputs" => array(),
                "textareas" => array(),
                "submit" => array(
                    "value" => " return to Penetration Test Commands ",
                    "display" => true,
                ),
                "reset" => array(
                    "display" => false,
                ),
            );
            self::_commands_format_to_form_textareas($_common_commands, $_form);
            $_top = Class_View_Top::top();
            $_body = array(
                "menu" => Class_View_Guide_PenetrationTestCommands_Menu::menu(),
                "content" => (($_form_top) . Class_View::form_body($_form)),
            );
            $_bottom = Class_View_Bottom::bottom();
            Class_Base_Response::output(Class_View::index($_top, $_body, $_bottom), "text", 0);
        }
        return null;
    }

    public static function social_engineering($params = array())
    {
        if ((!is_cli()) && (!Class_Base_Auth::is_login())) {
            Class_Base_Response::redirect("/login");
            return null;
        }
        $_common_commands = array(
            "social_engineering" => array(
                "setoolmaster" => array(
                    "title" => 'setoolmaster : ',
                    "describe" => '开源的社会工程学工具',
                    "command" => 'setoolmaster',
                    "examples" => array(
                        array(
                            "title" => "",
                            "describe" => "查看帮助信息",
                            "command" => "help",
                        ),
                    ),
                ),
            ),
        );
        Class_Base_Auth::check_permission();
        if (!is_cli()) {
            $_form_top = '<div style="margin-top:64px;margin-bottom:16px;height: 32px;text-align: center;font-size: 18px;">Social Engineering Commands</div>';
            $_form = array(
                "action" => "/guide/penetration_test_commands",
                "inputs" => array(),
                "textareas" => array(),
                "submit" => array(
                    "value" => " return to Penetration Test Commands ",
                    "display" => true,
                ),
                "reset" => array(
                    "display" => false,
                ),
            );
            self::_commands_format_to_form_textareas($_common_commands, $_form);
            $_top = Class_View_Top::top();
            $_body = array(
                "menu" => Class_View_Guide_PenetrationTestCommands_Menu::menu(),
                "content" => (($_form_top) . Class_View::form_body($_form)),
            );
            $_bottom = Class_View_Bottom::bottom();
            Class_Base_Response::output(Class_View::index($_top, $_body, $_bottom), "text", 0);
        }
        return null;
    }
}