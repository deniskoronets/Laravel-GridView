# DataProviders

Data providers are simple wrappers around any data source. You are open to extend/make your own/do what ever you want with current data providers which are:
- EloquentDataProvider
- ArrayDataProvider

In case you want to implement your own, please check `BaseDataProvider` class and extend this class.

**<!> Please note that `EloquentDataProvider` accepts `Builder`, not `Collection` instance as an argument b/c it modifies the query (of course with a copy of query, not original one).**