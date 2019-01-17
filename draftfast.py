from draftfast import rules
from draftfast.optimize import run, run_multi
from draftfast.orm import Player
from draftfast.settings import PlayerPoolSettings
from draftfast.csv_parse import salary_download
from draftfast.lineup_contraints import LineupConstraints

import csv

# Create players
player_pool = [
    Player(name='Kevin Harvick', cost=12500, proj=65.1, pos='D'),
    Player(name='Kyle Busch', cost=11800, proj=64.46, pos='D'),
    Player(name='Martin Truex Jr', cost=11300, proj=61.63, pos='D'),
    Player(name='Joey Logano', cost=10600, proj=55.09, pos='D'),
    Player(name='Kyle Larson', cost=10000, proj=60.52, pos='D'),
    Player(name='Chase Elliott', cost=9700, proj=51.28, pos='D'),
    Player(name='Brad Keselowski', cost=9400, proj=42.08, pos='D'),
    Player(name='Kurt Busch', cost=9200, proj=34.53, pos='D'),
    Player(name='Clint Bowyer', cost=9000, proj=60.21, pos='D'),
    Player(name='Denny Hamlin', cost=8800, proj=37.59, pos='D'),
    Player(name='Ryan Blaney', cost=8600, proj=40.71, pos='D'),
    Player(name='Aric Almirola', cost=8400, proj=34.95, pos='D'),
    Player(name='Erik Jones', cost=8200, proj=32.05, pos='D'),
    Player(name='Jimmie Johnson', cost=8000, proj=34.11, pos='D'),
    Player(name='Daniel Suarez', cost=7800, proj=28.06, pos='D'),
    Player(name='Austin Dillon', cost=7700, proj=23.08, pos='D'),
    Player(name='Ryan Newman', cost=7500, proj=17.79, pos='D'),
]

player_settings = PlayerPoolSettings(min_salary=0, max_salary=50000)

i = 20

rosters = run_multi(i, rule_set=rules.FD_NASCAR_RULE_SET, player_pool=player_pool, verbose=True)

notused =0