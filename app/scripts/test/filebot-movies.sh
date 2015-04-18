
INPUT_PATH="$1"
#LANGUAGE_SUBTITLES="%LANGUAGE_SUBTITLES%"

MOVIE_NAME_PATTERN="{n.upperInitial().replaceTrailingBrackets()} ({y})"

filebot -rename "$INPUT_PATH" -r --format "/mediacenter/Movies/$MOVIE_NAME_PATTERN/$MOVIE_NAME_PATTERN" --db themoviedb -get-subtitles "$INPUT_PATH" --lang en -non-strict
