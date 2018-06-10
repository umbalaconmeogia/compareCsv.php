# Design document

## Function requirements

1. Specify input csv file name.
1. Specify key column and compare column.
1. Output different row into csv file.
1. Display comparision result clearly (key value not exist, or values are different).
1. Can switch of seeing NULL string and empty string are the same or not.
1. Separator may be colon or tab.

## Basic design

### Syntax
  php compareCsv.php --file1=file1.csv --file2=file2.csv --keyColumn=0 --compareColumn=1 --nullEqualsEmpty --outputCsv=out.csv