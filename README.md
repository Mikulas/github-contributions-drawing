## Github Contributions renderer

Author: Mikulas Dite
License: BDS-3

### Usage:
 
1. update $pattern
    * for each whitespace in the leftmost column, write a dash `-`
    * draw in the rest of fields
        * 2 colors: draw in the rest of fields, dot `.` is white, hash `#` is colored
        * 5 colors: numbers: `0` - white, up to `4` - dark green
2. specify what date is on the very first dot (going by column)
3. update `$user` and `$email`.
4. push repo in `./draw_repo` to Github


### Example:
<img src="http://i44.tinypic.com/e8smki.png">
