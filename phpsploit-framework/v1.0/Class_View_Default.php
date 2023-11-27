<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 23-5-28
 * Time: 下午4:24
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

class Class_View_Default
{
    const DOCUMENT_CN_TITLE                                   = '用户协议与免责声明';
    const DOCUMENT_CN_BODY_TEXT_LINE_1                        = '第 一 条 phpsploit-framework 软件所提供的所有功能及信息仅可用于得到合法授权前提下的渗透测试、安全审计、安全技术研究与学习行为。phpsploit-framework 软件使用者(以下简称为“phpsploit-framework 软件用户”)明确同意在使用phpsploit-framework软件功能的过程中产生的一切风险将完全由phpsploit-framework 软件用户自己承担；因phpsploit-framework 软件用户使用phpsploit-framework软件所提供功能而产生的一切后果也完全由phpsploit-framework 软件用户自己承担；phpsploit-framework 软件作者对phpsploit-framework 软件用户在 phpsploit-framework 软件使用过程中给 phpsploit-framework 软件用户自己造成的任何影响及损失不承担任何责任；phpsploit-framework 软件作者对phpsploit-framework 软件用户在phpsploit-framework软件使用过程中给任何第三方造成的任何影响及损失不承担任何责任。';
    const DOCUMENT_CN_BODY_TEXT_LINE_2                        = '第 二 条 phpsploit-framework 软件用户在未取得被审计方以书面形式进行明确的合法授权情况下， phpsploit-framework 软件用户禁止使用 phpsploit-framework 软件向被审计方的网络环境、系统环境、数据库环境、办公环境等空间开展包括渗透测试、安全审计等在内的任何形式上的、可能会给被审计方造成各类风险及人身或经济损失伤害后果的所有行为；如因phpsploit-framework 软件用户的个人行为而给任何第三方造成任何影响及损失， phpsploit-framework 软件作者不承担任何责任。同时，phpsploit-framework 软件作者保留对 phpsploit-framework 软件用户在 phpsploit-framework 软件使用过程中发生的所有超越 phpsploit-framework 软件用途限制及相关约束的任何情况下产生的所有侵权行为进行法律追责的相关权利。';
    const DOCUMENT_CN_BODY_TEXT_LINE_3                        = '第 三 条 phpsploit-framework 软件用户在部署并使用 phpsploit-framework 软件之前， phpsploit-framework 软件用户必须对部署前环境进行完整数据备份，并同时做好相应安全处理（包括但不限于有效的容灾备份处理、有效的灾难恢复设置、有效的安全问题与故障问题记录等）。如因 phpsploit-framework 软件用户个人原因而导致被部署环境出现任何问题或产生任何人身、财产损失及影响，phpsploit-framework 软件作者不承担任何责任。';
    const DOCUMENT_CN_BODY_TEXT_LINE_4                        = '第 四 条 phpsploit-framework 软件用户在使用 phpsploit-framework 软件所提供功能时，可能会产生各类网络通信行为，这将可能导致相关流量通信费用的产生（注意：在非免费网络环境中，这种情况将变得比较明显），如 phpsploit-framework 软件用户无法接受此类通信与流量费用的产生，请避免在非免费网络环境中使用 phpsploit-framework 软件。由于 phpsploit-framework 软件用户自身网络原因而产生的流量费用，phpsploit-framework 软件作者不承担任何责任。';
    const DOCUMENT_CN_BODY_TEXT_LINE_5                        = '第 五 条 在使用 phpsploit-framework 软件提供的功能时， phpsploit-framework 软件用户必须保证自身环境与phpsploit-framework软件的部署环境之间的网络通信安全!不安全的局域网或广域网环境(例如使用HTTP协议进行web通信)可能导致phpsploit-framework软件用户在使用phpsploit-framework软件特性时受到网络黑客的恶意攻击(包括但不限于网络通信数据窃取、劫持等网络攻击)!这种情况的发生可能会导致 phpsploit-framework 软件的网络通信数据被窃取、篡改和恶意利用!不安全的网络通信环境会直接或间接地对 phpsploit-framework 软件的部署环境造成严重的安全威胁!如果 phpsploit-framework 软件用户无法保证自身环境和 phpsploit-framework 软件部署环境的网络通信安全(例如，网络通信使用不安全的HTTP协议，而不是更安全的HTTPS协议，或者 phpsploit-framework 软件用户自身也处于不受信任的网络环境中)， phpsploit-framework 软件用户应立即停止使用并卸载 phpsploit-framework 软件，删除使用 phpsploit-framework 软件上传、下载和创建的所有目录和文件，并将 phpsploit-framework 软件所在环境恢复到部署 phpsploit-framework 软件之前的环境。 如因 phpsploit-framework 软件用户自身或 phpsploit-framework 的部署环境中的安全问题而给 phpsploit-framework 软件用户自身及其它任何第三方造成任何直接和间接的影响，以及人身和财产损失(包括但不限于恶意黑客从事网络数据包捕获、通信数据劫持、恶意使用劫持的敏感信息等)，phpsploit-framework 软件作者不承担任何责任。';
    const DOCUMENT_CN_BODY_TEXT_LINE_6                        = '第 六 条 当政府司法机关依照法定程序要求phpsploit-framework 软件作者停止继续对外开放phpsploit-framework 软件的使用授权时，phpsploit-framework 软件作者将根据执法单位之要求或为公共安全之目的停止对外开放phpsploit-framework 软件的使用授权（phpsploit-framework 软件作者保留再次重新对外开放phpsploit-framework 软件使用授权的相关权利）。在此情况下，任何未经phpsploit-framework 软件作者重新授权的phpsploit-framework 软件使用行为都将被认定为侵权，phpsploit-framework 软件作者保留对其进行法律追究的相关权利。';
    const DOCUMENT_CN_BODY_TEXT_LINE_7                        = '第 七 条 在 phpsploit-framework 软件的生产环境中使用 phpsploit-framework 软件开发或测试环境密码是一种非常危险的行为（常见密码通常为更多人所知，这大大增加了 phpsploit-framework 软件被恶意攻击成功的风险）！ phpsploit-framework 软件附带了专门为创建生产环境帐户和密码信息而设计的相关功能模块（通常，使用 phpsploit-framework 软件内置功能模块创建的帐户和密码具有相对较高的安全强度）。如果 phpsploit-framework 软件的用户没有使用 phpsploit-framework 软件的固有功能模块来创建 phpsploit-framework 软件的帐户和密码信息，或者如果 phpsploit-framework 软件用户将 phpsploit-framework 软件的帐号和密码信息通知他人，则由此产生的所有责任后果（包括任何公共或私人数据泄露、其他个人或财产损失以及所有直接或间接影响）应由 phpsploit-framework 软件用户自行承担， phpsploit-framework 软件作者不承担责任。';
    const DOCUMENT_CN_BODY_TEXT_LINE_8                        = '第 八 条 phpsploit-framework 软件本身，可能会存在各类设计缺陷、代码编写错误、风险漏洞等安全问题，phpsploit-framework软件作者无法保证phpsploit-framework 软件所提供功能的绝对安全性、绝对稳定性、绝对正确性、绝对完整性、绝对兼容性等情况，phpsploit-framework 软件作者将尽力去减少此类问题情况的发生，尽可能地去对已发现问题并进行问题修复。尽管如此，phpsploit-framework 软件仍可能存在未被修复或未被发现的安全漏洞和软件错误问题。phpsploit-framework 软件用户在使用phpsploit-framework软件的过程中如果发生任何问题，phpsploit-framework 软件作者均得免责。';
    const DOCUMENT_CN_BODY_TEXT_LINE_9                        = '第 九 条 phpsploit-framework 软件属于开源软件，遵循开源软件规则（GPLv3：GNU 公共许可证），但 phpsploit-framework 软件作者对于 phpsploit-framework 软件的开源程度，仍然做了一定的补充性约束（这主要是为了在一定程度上保证 phpsploit-framework 软件的可控性及后续良性发展！ phpsploit-framework 软件作者认为，失控的开源软件是非常危险的），补充性约束内容包括：phpsploit-framework 软件用户可以在一定程度上对其所获得的 phpsploit-framework 软件 进行修改、优化，但经过其自行修改优化后的phpsploit-framework 软件变体版本仅限phpsploit-framework 软件用户自己与其自身工作团队内部使用，经过 phpsploit-framework 软件用户修改优化后的phpsploit-framework 软件变体版本，不得以新软件身份公开对外发布（phpsploit-framework 软件用户可考虑将自行修改优化后的phpsploit-framework 软件变体提交给 phpsploit-framework 软件作者，由 phpsploit-framework 软件作者对 phpsploit-framework 软件用户提交的软件变体版本代码进行审核，在审核通过之后，phpsploit-framework 软件作者会将phpsploit-framework 软件用户提交的软件变体统一发布到phpsploit-framework 软件的官方平台。phpsploit-framework 软件作者将在变体分支上保留变体提交者的署名，用以鼓励与支持变体提交者对phpsploit-framework 软件作出的优秀贡献）。同时，phpsploit-framework 软件用户务必在 phpsploit-framework 软件的修改变体上保留 phpsploit-framework 软件原作者对于 phpsploit-framework 软件的全部权利声明（包括但不限于 phpsploit-framework 软件的版权及软件著作权声明等）。';
    const DOCUMENT_CN_BODY_TEXT_LINE_10                       = '第 十 条 任何由于黑客攻击、计算机病毒侵入或发作、因政府管制等而造成的软件功能性关闭、软件功能缺失、软件功能遭受篡改与恶意利用等影响软件正常运行的不可抗力而造成的公\私资料泄露、丢失、被盗用或被篡改等，phpsploit-framework 软件作者均得免责。';
    const DOCUMENT_CN_BODY_TEXT_LINE_11                       = '第 十 一 条 由于与phpsploit-framework 软件链接的其它第三方软件功能或网络站点所造成的公\私资料泄露及由此而导致的任何法律争议和后果，phpsploit-framework 软件作者均得免责。';
    const DOCUMENT_CN_BODY_TEXT_LINE_12                       = '第 十 二 条 phpsploit-framework 软件如因软件功能维护或升级而需新增、关停、卸载相关软件重要功能时，将在软件版本更新或软件上架下架时进行公告。若因phpsploit-framework 软件作者控制能力范围外的软硬件故障或其它不可抗力（如黑客攻击等）而导致软件功能遭破坏或篡改等，给 phpsploit-framework 软件用户造成的一切风险与损失，phpsploit-framework 软件作者不负任何责任。';
    const DOCUMENT_CN_BODY_TEXT_LINE_13                       = '第 十 三 条 phpsploit-framework 软件用户因为违反本声明的规定而触犯所在国家法律的，一切后果全部由 phpsploit-framework 软件用户自己负责与承担，phpsploit-framework 软件作者不承担任何责任。';
    const DOCUMENT_CN_BODY_TEXT_LINE_14                       = '第 十 四 条 任何人以任何方式下载或使用 phpsploit-framework 软件，或直接或间接使用属于 phpsploit-framework 软件的任何源代码（不属于phpsploit-framework 软件的第三方代码库中的代码不在此限制范围之内），都将被视为自愿接受 phpsploit-framework 软件声明的所有限制。';
    const DOCUMENT_CN_BODY_TEXT_LINE_15                       = '第 十 五 条 本声明未涉及的问题参见国家有关法律法规，当本声明与国家法律法规冲突时，以国家法律法规为准。';
    const DOCUMENT_CN_BODY_TEXT_LINE_16                       = '第 十 六 条 phpsploit-framework 软件作者不担保 phpsploit-framework 软件功能一定能满足 phpsploit-framework 软件用户的要求，也不担保 phpsploit-framework 软件功能不会存在任何的安全风险，对 phpsploit-framework 软件功能的及时性、安全性、稳定性、完整性、准确性、兼容性等也都不作任何担保。';
    const DOCUMENT_CN_BODY_TEXT_LINE_17                       = '第 十 七 条 phpsploit-framework 软件作者不保证为向phpsploit-framework 软件用户提供便利而设置的外部链接的准确性、完整性、安全性、及时性。同时，对于该等外部链接指向的不由phpsploit-framework 软件作者实际控制的任何资源或网页上的内容，phpsploit-framework 软件作者不承担任何责任。';
    const DOCUMENT_CN_BODY_TEXT_LINE_18                       = '第 十 八 条 对于因不可抗力或phpsploit-framework 软件作者不能控制的原因造成的软件功能异常或其它安全风险性情况的，phpsploit-framework 软件作者不承担任何责任，但将尽力减少因此而给phpsploit-framework 软件用户造成的损失和影响。';
    const DOCUMENT_CN_BODY_TEXT_LINE_19                       = '第 十 九 条 phpsploit-framework 软件作者所发的第三方项目名称、第三方项目链接、第三方音视频资料、第三方文字图片资料等分享内容，仅是第三方项目信息介绍，并不能作为第三方与phpsploit-framework 软件作者存在合作关系的有效判断依据。phpsploit-framework 软件用户应理性对待第三方项目的信息介绍内容（第三方项目权属由于归第三方所有，因此phpsploit-framework 软件作者无法保证第三方项目的绝对安全、正确、实时、有效等情况，phpsploit-framework 软件用户在访问及使用第三方项目内容时需自行鉴别与处理第三方项目内容可能涉及的内容安全性、正确性、有效性、实时性等问题），对于phpsploit-framework 软件用户由于看到此类信息，付诸相应反映行动而造成损失或其它后果的， phpsploit-framework 软件作者不承担任何责任。';
    const DOCUMENT_CN_BODY_TEXT_LINE_20                       = '第 二 十 条 phpsploit-framework 软件作者拥有phpsploit-framework软件的包括版权及软件著作权等在内的全部权利，phpsploit-framework软件作者对外公开发放的仅为phpsploit-framework软件的软件使用授权，且仅在phpsploit-framework 软件用户在合法合规前提下使用本 phpsploit-framework 软件所提供功能时，phpsploit-framework 软件用户才被认可为已获得了phpsploit-framework 软件作者对于phpsploit-framework软件功能使用的合法授权，否则将视为phpsploit-framework 软件用户违反了本用户协议内容约定，对phpsploit-framework软件作者构成侵权行为。phpsploit-framework软件作者将保留对phpsploit-framework 软件用户的侵权行为进行依法追责的相关权利。';
    const DOCUMENT_CN_BODY_TEXT_LINE_21                       = '第 二 十 一 条 phpsploit-framework 软件用户不得以任何形式将 phpsploit-framework 软件用于商业用途或商业活动。如果 phpsploit-framework 软件用户需要将 phpsploit-framework 软件用于商业用途或商业活动，则必须事先得到 phpsploit-framework 软件作者对其进行的额外授权，否则即被认定为 phpsploit-framework 软件用户的行为已对 phpsploit-framework 软件作者构成侵权。';
    const DOCUMENT_CN_BODY_TEXT_LINE_22                       = '第 二 十 二 条 phpsploit-framework 软件的开源规则基于GPLv3开源协议，本《用户协议与免责声明》的所有内容将以补充条款的形式对 phpsploit-framework 软件用户形成法律约束。本《用户协议与免责声明》中的所有内容与《GPLv3开源协议》中的所有内容具有同等的法律约束力。如果GPLv3开源协议中的内容与本用户协议和免责声明中的内容产生冲突，则以本用户协议和免责声明中的内容为准。';
    const DOCUMENT_CN_BODY_TEXT_LINE_23                       = '第 二 十 三 条 phpsploit-framework 软件之声明以及其修改权、更新权及最终解释权均属phpsploit-framework 软件作者所有。';
    const DOCUMENT_CN_CONFIRM                                 = '注意：继续使用本软件，即代表您已接受并认可上述所有用户协议与免责声明条款！如您拒绝接受上述条款内容，请立即停止使用本软件！否则将被视为侵权行为，软件作者保留追究侵权责任的合法权利。';
    const DOCUMENT_CN_COMMAND_LINE_FORM_PARAMETER_DESCRIPTION = '说明：在CLI模式下使用本软件时，传递表单参数（is_enable_license_agreement=1），即可不再显示此用户协议与免责声明信息！is_enable_license_agreement 参数值含义：0=拒绝接受协议内容；1=同意接受协议内容。';

    const DOCUMENT_EN_TITLE                                   = 'User Authorization and License Agreement (Disclaimer)';
    const DOCUMENT_EN_BODY_TEXT_LINE_1                        = '1、All functions and information provided by the Phpsploit-Framework software can only be used for penetration testing, security auditing, security technology research, and learning behavior with legal authorization. The user of the Phpsploit-Framework software (hereinafter referred to as the "Phpsploit-Framework software user") expressly agrees that all risks arising from the use of the functions of the Phpsploit-Framework software will be solely borne by the Phpsploit-Framework software user; All consequences arising from the use of the functions provided by the Phpsploit-Framework software by users of the Phpsploit-Framework software shall be entirely borne by the users of the Phpsploit-Framework software themselves; The author of the Phpsploit-Framework software shall not be liable for any impact or loss caused by users of the Phpsploit-Framework software during their use; The author of the Phpsploit-Framework software shall not be liable for any impact or loss caused to any third party by users of the Phpsploit-Framework software during its use.';
    const DOCUMENT_EN_BODY_TEXT_LINE_2                        = '2、Users of the Phpsploit-Framework software are prohibited from engaging in any form of behavior that may lead to harmful consequences in the audited party\'s network environment, system environment, database environment, office environment, and other spaces without obtaining explicit written legal authorization from the audited party, including penetration testing, security auditing, etc. If any impact or loss is caused to any third party due to the personal behavior of the users of the Phpsploit-Framework software, the author of the Phpsploit-Framework software shall not be liable. At the same time, the author of the Phpsploit-Framework software reserves the right to pursue legal liability for any infringement of the Phpsploit-Framework software user agreement by Phpsploit-Framework software users.';
    const DOCUMENT_EN_BODY_TEXT_LINE_3                        = '3、Before deploying and using the Phpsploit-Framework software, users of the Phpsploit-Framework software must perform a complete data backup of the pre deployment environment and take corresponding security measures (including but not limited to effective disaster recovery backup measures, effective disaster recovery settings, effective security and fault recording measures, etc.) to ensure that in the event of unexpected situations, The deployed environment of the Phpsploit-Framework software can be restored to the pre deployment environment.If any problems occur in the deployed environment (including any personal or property damage, etc.) due to personal reasons of the users of the Phpsploit-Framework software, the author of the Phpsploit-Framework software shall not be liable.';
    const DOCUMENT_EN_BODY_TEXT_LINE_4                        = '4、Phpsploit-Framework software users may experience various network communication behaviors when using the functions provided by Phpsploit-Framework software, which may result in related traffic communication costs (for example, if you use Phpsploit-Framework software in the data connection mode of a mobile communication operator). If Phpsploit-Framework software users cannot accept such communication and the related network traffic costs that may arise from it, Please avoid using Phpsploit-Framework software. The author of the Phpsploit-Framework software shall not be responsible for any traffic expenses incurred by users of the Phpsploit-Framework software due to their own network reasons.';
    const DOCUMENT_EN_BODY_TEXT_LINE_5                        = '5、When using the functions provided by Phpsploit-Framework software, users of Phpsploit-Framework software must ensure network communication security between their own environment and the deployment environment of Phpsploit-Framework software! Unsecure local or wide area network environments (such as using the HTTP protocol for web communication) may result in Phpsploit-Framework software users being subjected to malicious attacks from network hackers during the use ofPhpsploit-Framework software features (including but not limited to network communication data theft, hijacking, and other network attacks)! The occurrence of this situation may cause the network communication data of Phpsploit-Framework software to be stolen, tampered with, and maliciously utilized! An insecure network communication environment can directly or indirectly pose a serious security threat to the deployment environment of Phpsploit-Framework software! If Phpsploit-Framework software users are unable to ensure the network communication security of their own environment and the deployment environment of Phpsploit-Framework software (for example, network communication uses the insecure HTTP protocol instead of the more secure HTTPS protocol, or Phpsploit-Framework software users themselves are also in an untrusted network environment), Users of the Phpsploit-Framework software should immediately stop using and uninstall the Phpsploit-Framework software, delete all directories and files uploaded, downloaded, and created using the Phpsploit-Framework software, and restore the environment where the Phpsploit-Framework software was located to the environment before the Phpsploit-Framework software was deployed. Various direct and indirect impacts, as well as personal and property losses, caused by security issues in the Phpsploit-Framework software user\'s own or deployment environment (including but not limited to malicious hackers engaging in network packet capturing, communication data hijacking, malicious use of hijacked sensitive information, etc.), The author of the Phpsploit-Framework software does not assume any responsibility.';
    const DOCUMENT_EN_BODY_TEXT_LINE_6                        = '6、When the government judicial authorities, in accordance with legal procedures, require authors of the Phpsploit-Framework software to stop continuing to open the use authorization of the Phpsploit-Framework software to the public, The author of the Phpsploit-Framework software will cease the authorization of the use of the Phpsploit-Framework software to the public in accordance with the requirements of law enforcement agencies or for public safety purposes (the author of the Phpsploit-Framework software reserves the right to reopen the Phpsploit-Framework software to the public again). In this case, if a user of the Phpsploit-Framework software continues to use the Phpsploit-Framework software without obtaining re authorization from the author of the Phpsploit-Framework software, it will be considered an infringement on the author of the Phpsploit-Framework software, and the author of the Phpsploit-Framework software reserves the relevant rights to pursue legal action against them.';
    const DOCUMENT_EN_BODY_TEXT_LINE_7                        = '7、Using Phpsploit-Framework software development or testing environment passwords in the production environment of Phpsploit-Framework software is a very dangerous behavior (common passwords are usually known to more people, which greatly increases the risk of Phpsploit-Framework software being successfully attacked by malicious attacks)! The Phpsploit-Framework software comes with relevant functional modules specifically designed for creating production environment accounts and password information (usually, accounts and passwords created using the built-in functional modules of the Phpsploit-Framework software have relatively high security strength). If users of the Phpsploit-Framework software do not use the inherent functional modules of the Phpsploit-Framework software to create account and password information of the Phpsploit-Framework software, Or if the user of the Phpsploit-Framework software notifies others of the account and password information of the Phpsploit-Framework software, then all liability consequences arising from this (including any public or private data leakage, other personal or property losses, and all direct or indirect impacts) shall be borne by the Phpsploit-Framework software user, and the Phpsploit-Framework software author shall not be liable.';
    const DOCUMENT_EN_BODY_TEXT_LINE_8                        = '8、The Phpsploit-Framework software itself may have various security issues, such as design flaws, code writing errors, and risk vulnerabilities. The author of the Phpsploit-Framework software cannot guarantee the absolute security, stability, accuracy, completeness, and compatibility of the functions provided by the Phpsploit-Framework software. The authors of the Phpsploit-Framework software will make every effort to reduce the occurrence of such problems, actively explore security risks as much as possible, and fix identified security risk issues. However, there may still be security vulnerabilities and software error issues that have not been fixed or discovered in the Phpsploit-Framework software. If users of the Phpsploit-Framework software encounter any issues while using the Phpsploit-Framework software, the author of the Phpsploit-Framework software shall be exempt from liability.';
    const DOCUMENT_EN_BODY_TEXT_LINE_9                        = '9、Phpsploit-Framework software belongs to open source software and follows the rules of open source software (GPLv3: GNU public license), but the author of Phpsploit-Framework software has some supplementary constraints on its use (mainly to ensure the controllability and subsequent healthy development of Phpsploit-Framework software to a certain extent)! Supplementary constraints include: users of the Phpsploit-Framework software can modify and optimize the Phpsploit-Framework software to a certain extent. However, the variant version of the Phpsploit-Framework software that has been modified and optimized by users of the Phpsploit-Framework software is only available for internal use by Phpsploit-Framework software users and their own work teams. The variant version of the Phpsploit-Framework software that has been modified and optimized by users of the Phpsploit-Framework software is not allowed to be publicly released as a new software. Phpsploit-Framework software users can consider submitting their modified and optimized versions of Phpsploit-Framework software variants to the authors of the Phpsploit-Framework software. The author of the Phpsploit-Framework software will review the software variant version code submitted by users of the Phpsploit-Framework software. After approval, the author of the Phpsploit-Framework software will publish all software variants submitted by users of the Phpsploit-Framework software to the official platform of the Phpsploit-Framework software. The author of the Phpsploit-Framework software will retain the signature of the variant submitter on the variant branch to encourage and support the outstanding contributions made by the variant submitter to the Phpsploit-Framework software. At the same time, users of the Phpsploit-Framework software must retain all rights notices of the original author of the Phpsploit-Framework software regarding modifications and variations of the Phpsploit-Framework software (including but not limited to the copyright and software copyright notices of the Phpsploit-Framework software).';
    const DOCUMENT_EN_BODY_TEXT_LINE_10                       = '10、The author of the Phpsploit-Framework software shall not be held responsible for any public or private data leakage, loss, theft, or tampering caused by force majeure that affects the normal operation of the software, such as hacker attacks, computer virus intrusion or outbreak, government regulation, etc.';
    const DOCUMENT_EN_BODY_TEXT_LINE_11                       = '11、The author of the Phpsploit-Framework software shall not be liable for any legal disputes or consequences arising from the leakage, damage, loss of public or private data caused by other third-party software functions or network sites linked to the Phpsploit-Framework software.';
    const DOCUMENT_EN_BODY_TEXT_LINE_12                       = '12、If important software features need to be added, closed, or uninstalled due to software functionality maintenance or upgrades, notifications will be made during the version update or removal process of the Phpsploit-Framework software. If the software functionality is damaged or tampered with due to software or hardware failures or other force majeure beyond the control of the Phpsploit-Framework software author (such as hacker attacks), and all risks and losses caused to Phpsploit-Framework software users as a result, the Phpsploit-Framework software author shall not be liable.';
    const DOCUMENT_EN_BODY_TEXT_LINE_13                       = '13、If a user of the Phpsploit-Framework software violates the laws of their country due to violating the provisions of this statement, all consequences shall be the responsibility and responsibility of the Phpsploit-Framework software user, and the author of the Phpsploit-Framework software shall not be held responsible.';
    const DOCUMENT_EN_BODY_TEXT_LINE_14                       = '14、Any person who downloads or uses the Phpsploit-Framework software in any way, or directly or indirectly uses any source code belonging to the Phpsploit-Framework software (excluding code in third party code libraries), will be deemed to voluntarily accept all restrictions stated by the Phpsploit-Framework Software.';
    const DOCUMENT_EN_BODY_TEXT_LINE_15                       = '15、The issues not covered in this statement refer to relevant national laws and regulations. In case of conflicts between this statement and national laws and regulations, national laws and regulations shall prevail.';
    const DOCUMENT_EN_BODY_TEXT_LINE_16                       = '16、The author of the Phpsploit-Framework software does not guarantee that the functionality of the Phpsploit-Framework software will meet the requirements of Phpsploit-Framework software users, nor does it guarantee that the functionality of the Phpsploit-Framework software will not pose security risks, nor does it guarantee the timeliness, security, stability, integrity, accuracy, compatibility, and other aspects of the Phpsploit-Framework software.';
    const DOCUMENT_EN_BODY_TEXT_LINE_17                       = '17、The author of the phpsploit framework software does not guarantee the accuracy, completeness, security, or timeliness of external links set up to provide convenience to users of the phpsploit framework software. At the same time, the author of the phpsploit framework software shall not be responsible for any resources or content on web pages that are not actually controlled by the author of the phpsploit framework software, as pointed to by such external links.';
    const DOCUMENT_EN_BODY_TEXT_LINE_18                       = '18、The authors of the Phpsploit Framework Software shall not be liable for any abnormal software function or other security risks due to force majeure or causes beyond the author\'s expectation and control, but will make every effort to minimize the loss and impact on the users of the Phpsploit Framework software.';
    const DOCUMENT_EN_BODY_TEXT_LINE_19                       = '19、The shared content published by the author of phpsploit-framework software (including third-party project names, third-party project links, third-party audio and video materials, third-party graphic materials, etc.) is only an introduction to third-party project information, and cannot be used as an effective basis for determining whether there is a cooperative relationship between the two parties. The user of phpsploit-framework software should rationally treat the content introduced by the third party project information (because the ownership of the third party project belongs to the third party, the author of phpsploit-framework software cannot guarantee the absolute security, correctness, real-time and effectiveness of the third party project)!   Users of phpsploit-framework software need to independently identify and deal with issues such as security, accuracy, effectiveness and real-time performance of third-party projects!   The author of the phpsploit-framework software shall not be liable for any loss or other consequences caused by the user of the phpsploit-framework software seeing this information and acting accordingly.';
    const DOCUMENT_EN_BODY_TEXT_LINE_20                       = 'The author of the Phpsploit-Framework software owns all rights to the Phpsploit-Framework software, including copyright and software copyright.    The author only publicly releases the software use authorization of Phpsploit-Framework software, and only when Phpsploit-Framework software users use the functions provided by Phpsploit-Framework software under legal and compliant conditions, The Phpsploit-Framework software user\'s behavior of using Phpsploit-Framework software is considered to have obtained the legal authorization of the Phpsploit-Framework software author.    Otherwise, it will be deemed that the Phpsploit-Framework software user has violated the provisions of this user agreement, constituting infringement of the Phpsploit-Framework software author.    The author of Phpsploit-Framework software reserves the right to pursue the infringement liability of Phpsploit-Framework software users according to law.';
    const DOCUMENT_EN_BODY_TEXT_LINE_21                       = '21、Phpsploit-Framework Software Users shall not use Phpsploit-Framework software for commercial purposes or commercial activities in any form. If the Phpsploit-Framework software user needs to use the Phpsploit-Framework software for commercial purposes or commercial activities, it must obtain additional authorization from the Phpsploit-Framework software author in advance. Otherwise, it is considered that the behavior of the Phpsploit-Framework software user has infringed the Phpsploit-Framework software author.';
    const DOCUMENT_EN_BODY_TEXT_LINE_22                       = '22、The open source rules of Phpsploit-Framework software are based on the GPLv3 open source Agreement, and all contents of this "User Agreement and Disclaimer" will form legal constraints for Phpsploit-Framework software users in the form of supplementary terms.  All contents in this "User Agreement and Disclaimer" shall have the same legal binding effect as all contents in the GPLv3 Open Source Agreement.  In the event of a conflict between the content of the GPLv3 Open Source Agreement and the content of this User Agreement and Disclaimer, the content of this User Agreement and Disclaimer shall prevail.';
    const DOCUMENT_EN_BODY_TEXT_LINE_23                       = '23、The statement of the Phpsploit-Framework software, as well as its modification, update, and final interpretation rights, belong to the author of the Phpsploit-Framework software.';
    const DOCUMENT_EN_CONFIRM                                 = 'Attention: Continuing to use this software means that you have accepted and recognized all the user agreements and disclaimer terms mentioned above! If you refuse to accept the above terms and conditions, please immediately stop using this software! Otherwise, it will be considered as an infringement, and the software author reserves the legal right to pursue infringement liability.';
    const DOCUMENT_EN_COMMAND_LINE_FORM_PARAMETER_DESCRIPTION = 'Explanation: When using this software in CLI mode, passing the form parameter (is_enable_license_agreement=1) will no longer display this user protocol and disclaimer information! Is_ Enable_ License_ The meaning of the agreement parameter value: 0=Refuse to accept the agreement content; 1=Agree to accept the agreement content.';


    private static $_document_body = "";

    public static function get_document_title ()
    {
        $_lang = Class_Base_Request::form ( "lang" , "string" , "en" );
        if ( $_lang == "cn" ) {
            return self::DOCUMENT_CN_TITLE;
        } else {
            return self::DOCUMENT_EN_TITLE;
        }
    }

    public static function get_document_body ()
    {
        $_lang = Class_Base_Request::form ( "lang" , "string" , "en" );
        if ( $_lang == "cn" ) {
            self::$_document_body = "\n";
            self::$_document_body .= "\n" . self::DOCUMENT_CN_BODY_TEXT_LINE_1 . "\n";
            self::$_document_body .= "\n" . self::DOCUMENT_CN_BODY_TEXT_LINE_2 . "\n";
            self::$_document_body .= "\n" . self::DOCUMENT_CN_BODY_TEXT_LINE_3 . "\n";
            self::$_document_body .= "\n" . self::DOCUMENT_CN_BODY_TEXT_LINE_4 . "\n";
            self::$_document_body .= "\n" . self::DOCUMENT_CN_BODY_TEXT_LINE_5 . "\n";
            self::$_document_body .= "\n" . self::DOCUMENT_CN_BODY_TEXT_LINE_6 . "\n";
            self::$_document_body .= "\n" . self::DOCUMENT_CN_BODY_TEXT_LINE_7 . "\n";
            self::$_document_body .= "\n" . self::DOCUMENT_CN_BODY_TEXT_LINE_8 . "\n";
            self::$_document_body .= "\n" . self::DOCUMENT_CN_BODY_TEXT_LINE_9 . "\n";
            self::$_document_body .= "\n" . self::DOCUMENT_CN_BODY_TEXT_LINE_10 . "\n";
            self::$_document_body .= "\n" . self::DOCUMENT_CN_BODY_TEXT_LINE_11 . "\n";
            self::$_document_body .= "\n" . self::DOCUMENT_CN_BODY_TEXT_LINE_12 . "\n";
            self::$_document_body .= "\n" . self::DOCUMENT_CN_BODY_TEXT_LINE_13 . "\n";
            self::$_document_body .= "\n" . self::DOCUMENT_CN_BODY_TEXT_LINE_14 . "\n";
            self::$_document_body .= "\n" . self::DOCUMENT_CN_BODY_TEXT_LINE_15 . "\n";
            self::$_document_body .= "\n" . self::DOCUMENT_CN_BODY_TEXT_LINE_16 . "\n";
            self::$_document_body .= "\n" . self::DOCUMENT_CN_BODY_TEXT_LINE_17 . "\n";
            self::$_document_body .= "\n" . self::DOCUMENT_CN_BODY_TEXT_LINE_18 . "\n";
            self::$_document_body .= "\n" . self::DOCUMENT_CN_BODY_TEXT_LINE_19 . "\n";
            self::$_document_body .= "\n" . self::DOCUMENT_CN_BODY_TEXT_LINE_20 . "\n";
            self::$_document_body .= "\n" . self::DOCUMENT_CN_BODY_TEXT_LINE_21 . "\n";
            self::$_document_body .= "\n" . self::DOCUMENT_CN_BODY_TEXT_LINE_22 . "\n";
            self::$_document_body .= "\n" . self::DOCUMENT_CN_BODY_TEXT_LINE_23 . "\n";
            self::$_document_body .= "\n";
        } else {
            self::$_document_body = "\n";
            self::$_document_body .= "\n" . self::DOCUMENT_EN_BODY_TEXT_LINE_1 . "\n";
            self::$_document_body .= "\n" . self::DOCUMENT_EN_BODY_TEXT_LINE_2 . "\n";
            self::$_document_body .= "\n" . self::DOCUMENT_EN_BODY_TEXT_LINE_3 . "\n";
            self::$_document_body .= "\n" . self::DOCUMENT_EN_BODY_TEXT_LINE_4 . "\n";
            self::$_document_body .= "\n" . self::DOCUMENT_EN_BODY_TEXT_LINE_5 . "\n";
            self::$_document_body .= "\n" . self::DOCUMENT_EN_BODY_TEXT_LINE_6 . "\n";
            self::$_document_body .= "\n" . self::DOCUMENT_EN_BODY_TEXT_LINE_7 . "\n";
            self::$_document_body .= "\n" . self::DOCUMENT_EN_BODY_TEXT_LINE_8 . "\n";
            self::$_document_body .= "\n" . self::DOCUMENT_EN_BODY_TEXT_LINE_9 . "\n";
            self::$_document_body .= "\n" . self::DOCUMENT_EN_BODY_TEXT_LINE_10 . "\n";
            self::$_document_body .= "\n" . self::DOCUMENT_EN_BODY_TEXT_LINE_11 . "\n";
            self::$_document_body .= "\n" . self::DOCUMENT_EN_BODY_TEXT_LINE_12 . "\n";
            self::$_document_body .= "\n" . self::DOCUMENT_EN_BODY_TEXT_LINE_13 . "\n";
            self::$_document_body .= "\n" . self::DOCUMENT_EN_BODY_TEXT_LINE_14 . "\n";
            self::$_document_body .= "\n" . self::DOCUMENT_EN_BODY_TEXT_LINE_15 . "\n";
            self::$_document_body .= "\n" . self::DOCUMENT_EN_BODY_TEXT_LINE_16 . "\n";
            self::$_document_body .= "\n" . self::DOCUMENT_EN_BODY_TEXT_LINE_17 . "\n";
            self::$_document_body .= "\n" . self::DOCUMENT_EN_BODY_TEXT_LINE_18 . "\n";
            self::$_document_body .= "\n" . self::DOCUMENT_EN_BODY_TEXT_LINE_19 . "\n";
            self::$_document_body .= "\n" . self::DOCUMENT_EN_BODY_TEXT_LINE_20 . "\n";
            self::$_document_body .= "\n" . self::DOCUMENT_EN_BODY_TEXT_LINE_21 . "\n";
            self::$_document_body .= "\n" . self::DOCUMENT_EN_BODY_TEXT_LINE_22 . "\n";
            self::$_document_body .= "\n" . self::DOCUMENT_EN_BODY_TEXT_LINE_23 . "\n";
            self::$_document_body .= "\n";
        }
        return self::$_document_body;
    }

    public static function get_document_confirm ()
    {
        $_lang = Class_Base_Request::form ( "lang" , "string" , "en" );
        if ( $_lang == "cn" ) {
            return self::DOCUMENT_CN_CONFIRM;
        } else {
            return self::DOCUMENT_EN_CONFIRM;
        }
    }

    public static function get_command_line_form_parameter_description ()
    {
        $_lang = Class_Base_Request::form ( "lang" , "string" , "en" );
        if ( $_lang == "cn" ) {
            return self::DOCUMENT_CN_COMMAND_LINE_FORM_PARAMETER_DESCRIPTION;
        } else {
            return self::DOCUMENT_EN_COMMAND_LINE_FORM_PARAMETER_DESCRIPTION;
        }
    }

    public static function index ( $params = array () )
    {
        $_lang = Class_Base_Request::form ( "lang" , "string" , "cn" );
        if ( ! is_cli () ) {
            return ( Class_View::form_page (
                array (
                    "title"   => "phpsploit-framework" ,
                    "content" => '<div style="height:16px;"></div><div style="line-height:32px;font-size:32px;text-align: center;">User Authorization and License Agreement (Disclaimer)</div><div style="height:32px;"></div>' ,
                ) ,
                array (
                    "action"    => "/init" ,
                    "hiddens"   => array (
                        array (
                            "id"    => "is_enable_license_agreement" ,
                            "name"  => "is_enable_license_agreement" ,
                            "value" => 1 ,
                        ) ,
                    ) ,
                    "inputs"    => array (
                        array (
                            "id"       => "document_title" ,
                            "title"    => " " ,
                            "describe" => "title" ,
                            "name"     => "document_title" ,
                            "value"    => self::get_document_title () ,
                            "disabled" => "disabled" ,
                        ) ,
                    ) ,
                    "textareas" => array (
                        array (
                            "id"       => "document_body" ,
                            "title"    => " " ,
                            "describe" => "body" ,
                            "name"     => "document_body" ,
                            "value"    => self::get_document_body () ,
                            "disabled" => "disabled" ,
                            "style"    => 'height:3100px;' ,
                        ) ,
                    ) ,
                    "submit"    => array (
                        "value" => ( ( $_lang == "cn" ) ? " 同意 " : " I agree " ) ,
                    ) ,
                    "reset"     => array (
                        "value"  => ( ( $_lang == "cn" ) ? " 拒绝 " : " I refuse " ) ,
                        "events" => array (
                            "onclick" => ( ( $_lang == "cn" ) ? ( "alert('注意，如果您拒绝接受以上协议条款，则无法继续使用本软件所提供的全部功能！');" ) : ( "alert('Note that if you refuse to accept the above agreement terms, you will not be able to continue using all the features provided by this software!');" ) ) ,
                        ) ,
                    ) ,
                    "button"    => array (
                        "value"   => ( ( $_lang == "cn" ) ? " 切换用户协议的语言版本 " : " Switch the language version of the user agreement " ) ,
                        "display" => true ,
                        "events"  => array (
                            "onclick" => "document.location.href='" . Class_Base_Response::get_url ( "/" , array ( "lang" => ( ( $_lang == "cn" ) ? "en" : "cn" ) ) ) . "';" ,
                        ) ,
                    ) ,
                    "gets"      => array () ,
                ) ,
                array () )
            );
        }
        return null;
    }
}