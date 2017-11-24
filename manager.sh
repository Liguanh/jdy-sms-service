#!/bin/bash
set -e

#常用的目录变量的定义
project_dir=$(cd $(dirname $0); pwd -P)
source_dir="$project_dir/src"
gateway_dir="$source_dir/Gateways"

#网关相关信息
gateway_namespace="Liguanh\JdySms\Gateways;"
gateway_suffix="Gateway"
http_requeset_namespace="Liguanh\JdySms\Traits\HttpRequest;"
http_request_class="HttpRequest;"
config_namespace="Liguanh\JdySms\Configs\Config;"
config_class="Config"
message_namespace="Liguanh\JdySms\Interfaces\MessageInterface;"
message_class="MessageInterface"

source "$project_dir/base.sh"


#创建短信网关的类
function make_gateway()
{
    local class_name="$2"
    local file="$gateway_dir/$class_name$gateway_suffix.php"

    if [ ! -f "$file" ]; then
        #run_cmd "touch $file"
        write_class_content $class_name$gateway_suffix $file
    else
        echo "${RED} This file ${file} is already exists, please make sure what you want to add is right ${NC}"
        exit
    fi

    echo "${GREEN} The file $file is created sucess! ${NC}"
}


#写入创建网关类文件的内容
function write_class_content()
{
    local file="${2}"

cat>./tmp<<EOF
<?php 
namespace ${gateway_namespace}

use ${http_requeset_namespace}
use ${config_namespace}
use ${message_namespace}

class $1 extends $gateway_suffix
{
    use ${http_request_class}

    const ENDPOINT_URL = '';

    /**
     * @desc 短信发送方法
     * @param \$to
     * @param MessageInterface \$message
     * @param Config \$config
     * @return array|mixed|string
     * @throws GatewayErrorException
     */
    public function send(\$to, ${message_class} '\$message', ${config_class} \$config)
    {
        //TO DO send a simple sms
    }
}
EOF
    run_cmd "cat tmp >> ${file}"
    run_cmd "rm -f tmp"
}

#删除网关类的文件
function rm_gateway()
{
    local class_name="$2"
    local file="$gateway_dir/$class_name$gateway_suffix.php"

    if [ ! -f "${file}" ]; then
        echo "${RED} Delete faild, The file [$file] is not exists! ${NC}"
        exit;
    else
        run_cmd "rm -f ${file}"
    fi
}


#帮助函数
function help()
{

cat <<EOF
    Usage: manager.sh [options]

        All Commands are:

            make_gateway        ［option class_name]                     创建短信网关对应的类名，后跟要创建的类的名字
            rm_gateway          ［option class_name]                     删除短信网关的类文件,
            help                                                            帮助命令

            help show this message
EOF
}

action=${1:-help}

ALL_COMMANDS="make_gateway rm_gateway help"

list_cmd ALL_COMMANDS "$action" || action=help

$action "$@"
