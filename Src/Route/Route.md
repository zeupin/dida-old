# Route

Route的主要任务就是把一个Request，按照既定规则解析为[controller, action, arguments, flags]，然后执行dispatch()。