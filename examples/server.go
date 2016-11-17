package main

import (
	"github.com/smallnest/rpcx"
	"github.com/smallnest/rpcx/codec"
)

type Args struct {
	A int `msg:"a"`
	B int `msg:"b"`
}

type Reply struct {
	C int `msg:"c"`
}

//type HelloArgs struct {
//	Name string `msg:"name"`
//}

type HelloArgs string
type HelloReply string

//type HelloReply struct {
//	Hello string `msg:"hello"`
//}

type Arith int

func (t *Arith) Mul(args *Args, reply *Reply) error {
	reply.C = args.A * args.B
	return nil
}

func (t *Arith) Error(args *Args, reply *Reply) error {
	panic("ERROR")
}

func (t *Arith) Hello(args *HelloArgs, reply *HelloReply) error  {
	*reply = "hello: " + string(*args);
	return nil;
}

func main() {
	server := rpcx.NewServer()
	//server.ServerCodecFunc = codec.NewJSONRPC2ServerCodec
	server.ServerCodecFunc = codec.NewJSONRPCServerCodec;

	server.RegisterName("Arith", new(Arith))
	server.Serve("tcp", "127.0.0.1:8972")
}


