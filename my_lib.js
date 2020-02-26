function hello(obj) {
  return {
    "hello": "Hello " + obj.name + ", you are " + ((obj.age <= 18) ? "young" : "old") + "!",
    "status": "ok"
  };
}

function my_sum(obj) {
  return obj.n1 + obj.n2;
}

module.exports = {
  hello: hello,
  my_sum: my_sum
};

