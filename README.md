TestTemplateGeneratorByTSV
=========================
テストコンディションが列挙されたTSVファイルからテストコードのテンプレートを生成する。  
※まだgenerateの追加オプション無しのみしか実装してない

## Usage

~~~
Usage: {{exe_path}} <command> ...

    <command>
    --generate   : テストテンプレートを生成する。既存のテストコードへの追記も行える。※追記は未実装
    --replace    : 既存のテストファイルの名前を修正する。※未実装
    --tomarkdown : TSVファイルをマークダウン形式に変換する。※未実装
    --reflect    : テスト結果をテストコンディションの反映する。※未実装

example: php {{exe_path}} --generate -s test/input.tsv -o output.txt -t template/junit.txt

note: TSVファイルは1列目がテストNo、2列目に対象メソッド、3列目に説明、4列目以降にオプションを記述する。
~~~

### #generate

~~~
Usage: {{exe_path}} --generate -s <source_file> -o <output_file> -t <template_file> [options...]
TSVからテストテンプレートの生成する

    -s <source_file>   : テストコンディションが列挙されたTSVファイルを指定する。 (required)
    -o <output_file>   : テストテンプレートの出力先ファイル指定する。 (required)
    -t <template_file> : テストコードのテンプレートファイルを指定する。 (required)
    [options]
    -a               : 既存のファイルに追記する。既に記述されているテストケースは追記しない。oオプションが指定されている必要がある。
    --header <num>   : ヘッダーの行数を指定する。（default: 1）
~~~

### #replace

~~~
Usage: {{exe_path}} --replace -s <source_file> -o <output_file> -t <template_file> [options...]
既存のテストファイルの名前を修正する。

    -s <source_file>  : テストコンディションが列挙されたTSVファイルを指定する。 (required)
    -o <output_file>  : 修正対象のテストコードファイルを指定する。(required)
    -t <template_file> : テストコードのテンプレートファイルを指定する。 (required)
    [options]
    --header <num>   : ヘッダーの行数を指定する。（default: 1）
~~~

## Example

*command*
~~~
> php generator.php --generate -s test/input.tsv -o test/output.txt -t template/junit.txt
~~~

*test/input.tsv*
~~~
## sum()
no	method	context	option1	option2
A001	sum()	with nothing	int res = sum();	res == 0
A002	sum()	with N	int res = sum(5);	res == 5
A003	sum()	with N and M	int res = sum(3, 7);	res == 10
B004	concat()	with "hoge" and "piyo"	string res = concat("hoge", "piyo");	res == "hogepiyo"
B005	concat()	with ",#$23a" and "'#JAJD\"!"	string res = concat(",#$23a", "'#JAJD\"!");	res == ",#$23a'#JAJD\"!"
~~~

*test/output.txt*
~~~
    @Test
    public void testA001__sum_with_nothing() {
        // method: sum()
        // context: with nothing
        // int res = sum();
        // res == 0
    }

    @Test
    public void testA002__sum_with_N() {
        // method: sum()
        // context: with N
        // int res = sum(5);
        // res == 5
    }

    @Test
    public void testA003__sum_with_N_and_M() {
        // method: sum()
        // context: with N and M
        // int res = sum(3, 7);
        // res == 10
    }

    @Test
    public void testB004__concat_with__hoge__and__piyo_() {
        // method: concat()
        // context: with "hoge" and "piyo"
        // string res = concat("hoge", "piyo");
        // res == "hogepiyo"
    }

    @Test
    public void testB005__concat_with_____23a__and____JAJD____() {
        // method: concat()
        // context: with ",#$23a" and "'#JAJD\"!"
        // string res = concat(",#$23a", "'#JAJD\"!");
        // res == ",#$23a'#JAJD\"!"
    }
    
    
~~~
