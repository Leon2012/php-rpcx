package main

import (
	"github.com/smallnest/rpcx"
	"github.com/smallnest/rpcx/codec"
	"fmt"
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

type HelloArgs int
type HelloReply int

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
	if v, ok := interface{}(*args).(int); ok {
		a := 10 + v;
		*reply  = HelloReply(a);
	}
	return nil;
}

func (t *Arith) Add(i int, r *int) error {
	a :=  10 + i
	*r = a
	fmt.Printf("i: %v", i)
	return nil
}

func main() {
	server := rpcx.NewServer()
	server.ServerCodecFunc = codec.NewJSONRPC2ServerCodec
	//server.ServerCodecFunc = codec.NewJSONRPCServerCodec;

	server.RegisterName("Arith", new(Arith))
	server.Serve("tcp", "127.0.0.1:8972")
}


