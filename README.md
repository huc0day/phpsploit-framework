# phpsploit-framework
Phpsploit-Framework Software Technology White Paper

1.Software Introduction

Phpsploit-Framework is an open source CTF framework and vulnerability exploitation
development library. It is written in PHP language and designed specifically for penetration
testing and security audit behavior, aiming to help ethical hackers (penetration testing engineers,
IT auditors, security research and development engineers, etc.) more efficiently and quickly carry
out vulnerability mining and security audit work.
The software project address is https://github.com/huc0day/phpsploit-framework Use
github as the repository for open source code.

2.Software author

The author of Phpsploit-Framework software (net name "huc0day") is an ethical hacker
dedicated to the open source industry. I have served as a research and development engineer,
software architect, technical director, information security officer, senior IT auditor, and other
positions in multiple internet companies, specializing in related work in fields such as penetration
testing, reverse engineering, web security, binary security, and security software development.
Formerly a member of the early Red Guest Alliance, he has designed original works such as
network security programming framework, memory based database core engine, GDSC data
security communication protocol, and server intrusion alarm system since 2004. Contact email:
huc0day@outlook.com .

3. introduction to featured functions

Phpsploit-Framework software pioneered a shell communication environment based on raw sockets (proxyshell), which can bypass more than 80% of the firewall rules when conducting CTF competitions or penetration tests. Because the shell communication environment communicates directly based on IPv6 protocol, the rules of packet filtering based on transport layer can be invalidated. Based on the extended header feature of IPv6 protocol, the shell environment using IPv6 protocol for communication can realize the proxy forwarding function for shell command requests, and can break through the network defense environment based on IP address restrictions. Comprehensive evaluation shows that the shell communicationenvironment based on the network layer will have a higher level of concealment when conducting CTF competition or penetration test. If properly used, this shell communication environment based on raw sockets can become an effective weaponfor CTF competition or penetration test behavior!

A set of instant messaging system (Chat) based on c/s architecture has been integrated into Phpsploit-Framework software. Any environment where Phpsploit-Framework software is deployed can run the instant messaging system of Phpsploit-Framework software (note that the service side operation of this instant messaging system depends on shmop extension). The client of this instant messaging system is written in Java language, and the server is written in PHP language. The communication parties use TCP protocol for communication, The communication data has been encrypted in a relatively secure RSA asymmetric way (however, it should be noted that before you formally create and use the project program files of the production environment, you should modify the communication key information in the source code files of the client and server. Warning: it is not safe to use the original RSA key for data encryption! This may cause the communication data to be hijacked and decrypted successfully! The RSA key information of the client is located in the source code directory of the instant messaging project "Chat.system.lib.security.rsa" class. The RSA key information of the server is located in the "class_base_security_rsa" class of Phpsploit-Framework software). When the public chat environment may be attacked by social engineering, using the instant messaging function of Phpsploit-Framework software can also become a private choice for team cooperation and attack and defense cooperation.

Phpsploit-Framework software integrates a variety of shell environments internally. Compared with the traditional penetration test shell environment, most of the built-in shells of Phpsploit-Framework software integrate the function of secure communication. Webshell has used dynamic key technology to encrypt the communication data in real time, and the data key used in each communication isdifferent. The servershell based on c/s architecture has also used dynamic token and dynamic key technology to encrypt the communication data. Proxyshell technology also uses token token based on rules and dynamic encryption technology to improve the communication security of shell environment. At the same time, proxyshell also adopts white list mechanism to minimize the risk of malicious attack on proxyshell.

The database management function (database) built in the Phpsploit-Framework software has dynamically encrypted the transmitted data (the encryption key used for each communication is different). It can reduce the risk of communication data hijacking and malicious attack to a greater extent. This database management function module is subdivided into two sub modules: query and exec. According to the different characteristics of the module, the execution results of SQL statements in the database management function module will be reflected in different forms (for example, for multiple queries or update statements, the execution results corresponding to the statements will be displayed in the form of sets).

The self-contained elf format file parsing function of Phpsploit-Framework software provides relevant support for content parsing of ELF format binary content. Phpsploit-Framework software users can use this function for security analysis of binary content. This function can automatically extract the file header, program header table, section header table, program table and section table data of ELF format files, and display them in the specified format. When conducting CTF competition and penetration test, this function can provide certain data analysis support for overflow fuzzy test. Combined with the shared memory management function provided by Phpsploit-Framework software, you can further verify whether overflow class or remote code execution class vulnerabilities exist. When conducting penetration testing, it is very necessary to discover and effectively repair the security vulnerabilities in their own systems before malicious hackers! Comprehensive evaluation, the elf format file parsing function of phpsploit framework software is a very practical hard core capability with a wide range of application scenarios.

The internal shared memory management function (memory) of Phpsploit-Framework software provides the ability to manage the shared memory resources in the operating system. The number of shared memory resources that can be found and accessed by this shared memory management function is closely related to the permissions when running Phpsploit-Framework software. This function provides the ability to view, create, update, and clear shared memory resources. It can be used alone or in combination with the elf format file parsing function of Phpsploit-Framework software for fuzzy testing of binary security classes. This shared memory management function also manages some shared memory resources bound by the Phpsploit-Framework software itself. It can be said that this function is one of the very important core functions in Phpsploit-Framework software.

Compared with the file download function in the traditional penetration testing environment, the built-in file online download (WGet) function of Phpsploit-Framework software has more advantages. First of all, the online file download function of Phpsploit-Framework software can provide real-time display of download progress, which is conducive to Phpsploit-Framework software users' real-time observation of file download progress. At the same time, after the files downloaded using the file online download function are successfully saved on the server, a file name with significant identification will be generated (with the word.Phpsploit in the file name), which can facilitate the corresponding cleaning after the completion of penetration test and security audit.

The file management function (file) built in the Phpsploit-Framework software realizes the simple file management feature. The search function provided in the file management function can easily search the specified directory or file in the specified path; The browsing function provided in the file management function can easily view the contents of the directory under the specified path; The reading function provided in the file management function allows you to see the truth inside the file (for the displayof file content, there are two modes that can be switched, namely binary format and plain text format. For large volume files, paging browsing is supported, which can basically meet the analysis requirements for slightly larger files); The file creation function provided in the file management function can help you create the specified file under the specified path. At the same time, in order to facilitate management (for example, after the penetration test and security audit are completed, the corresponding file cleaning is carried out), the file name of the new file created by Phpsploit-Framework software will contain the words ".phpsploit". The file editing function provided in the file management function allows you to easily edit the corresponding files created or uploaded through the phpsploit framework software (but please note that editing large files may lead to server load increase, web page blocking, browser unresponsiveness, etc., please be careful to avoid editing large files); The file upload function provided in the file management function allows you to easily upload the corresponding files to the server space (but please be careful! Please do not upload files that you cannot effectively control to the server space, which may cause great risks to the server space). When the file is uploaded successfully, The file name of the newly uploaded file will contain the words ".phpsploit" (this setting is mainly for you to easily clean up the uploaded file after the completion of penetration test and security audit); The file deletion function provided in the file management function can quickly delete the relevant files downloaded, uploaded and created directly by Phpsploit-Framework software users using Phpsploit-Framework software; The file cleanup function provided in the file management function enables one click cleanup of related files (for example, related files with the words ".phpsploit"). Note that for security reasons, Phpsploit-Framework software is designed to only edit and delete the relevant files that Phpsploit-Framework software users directly download, upload and create using Phpsploit-Framework software! For relevant files that are not directly downloaded, uploaded or created by Phpsploit-Framework software, Phpsploit-Framework software will not be able to successfully edit, delete and other behaviors.

The built-in scanning function (scan) of Phpsploit-Framework software can help Phpsploit-Framework software users conveniently carry out web site survival status detection and host port open status detection. At the same time, a more distinctive design is that the built-in scanning function (scan) of the Phpsploit-Framework software also provides a very user-friendly experience and practical functions for security operation and maintenance personnel. By using the sample verification function provided in the scan function, the security operation and maintenance personnel only need to enter the corresponding paths of the sample directory and sampling directory respectively, and then click the "start scan samplerproof" button, You can perform content matching verification on the sampling directory based on the content of the specimen catalog The main matching contents include: 1. whether the number of subdirectories and files in the specimen directory is the same as the number of subdirectories and files in the sampling directory; 2. whether there are directories or files that do not exist in the specimen directory and its corresponding subdirectories in the sampling directory and its subordinate subdirectories; 3. whether the directories or files that exist in the specimen directory and its subordinate subdirectories are not found in the sampling directory and its corresponding subdirectories; 4. Does the file size in the specimen directory and its subdirectories differ from that in the sampling directory and its subdirectories, and does the file have different md5 or sha1 checksums. At the same time, the sample verification function (tapperproof) will provide a warning prompt (usually related information in red) for any abnormal content found!

The built-in encryption and decryption function (security) of the Phpsploit-Framework software provides a large number of practical online encryption and decryption tools. Phpsploit-Framework software users no longer need to search for corresponding data encryption and decryption tools through various channels! By using the built-in encryption and decryption function (security) of the Phpsploit-Framework software, you can complete encryption and decryption operations for the vast majority of general data (commonly used encryption and decryption operations include URLencode/code, base64 encode/code, crypt encode/code, openssl encode/code, md5, sha1, hash, etc.)!

The built-in report function of the Phpsploit-Framework software can very conveniently assist users of the Phpsploit-Framework software in creating vulnerability report documents online (in xls format).Through this report function, Phpsploit-Framework software users can easily create vulnerability reports without installing Excel software! When the vulnerability report is completed, users of the Phpsploit-Framework software can download the report file automatically generated based on the content of the vulnerability report online through the export vulnerability report function that comes with the report function.

The guidance manual function provided internally by the Phpsploit-Framework software integrates a large amount of penetration testing/security operation and maintenance documentation that the author of the Phpsploit-Framework software has been collecting and organizing for over a year (including the translation of a large amount of English materials, which consumes a lot of energy and time of the Phpsploit-Framework software author). In the guide function, specific usage of various commands is integrated. This includes utility related command usage in fields such as information collection, vulnerability analysis, web programs, database evaluation, password security, wireless security, reverse engineering, vulnerability exploitation, sniffing/spoofing, permission maintenance, digital forensics, security reporting, social engineering, etc.

4、Open source protocol conflict resolution

The open source rules of Phpsploit-Framework software are based on the GPLv3 open source protocol.      However, Phpsploit-Framework software authors have added some additional terms on the basis of the GPLv3 open source protocol (this is mainly to ensure the healthy development of Phpsploit-Framework software: It can only be used for penetration testing, security audit, security technology research and learning under the premise of legal authorization).      In case of conflict between the content in the GPLv3 open source agreement and the content in the additional terms, the content in the additional terms shall prevail.      For details about additional terms, see the “User Agreement and Disclaimer" content section in the Phpsploit-Framework software or " User_Agreement_and_Disclaimer.pdf "file.

5、Other Description

The latest version of the software can be obtained from the following location: https://github.com/huc0day/phpsploit-framework

The software license agreement content information, please visit: https://github.com/huc0day/phpsploit-framework/User_Agreement_and_Disclaimer.docx"

The software technology document content information, please visit: "https://github.com/huc0day/phpsploit-framework/Phpsploit-Framework_Software_Technology_White_Paper.docx"

The software error and function request tracking information, please visit: https://github.com/huc0day/phpsploit-framework/issues
