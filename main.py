from draftfast import rules
from draftfast.optimize import run, run_multi
from draftfast.orm import Player
from draftfast.settings import PlayerPoolSettings
from draftfast.csv_parse import salary_download
from draftfast.lineup_contraints import LineupConstraints

import csv

player_pool = []

with open('input.csv') as inputfile:
    csvreader = csv.reader(inputfile)
    isHeader = True
    for row in csvreader:
        if isHeader:
            minSalary = float(row[0])
            maxSalary = float(row[1])
            lineups = int(row[2])
            isHeader = False
        else:
            player = Player(name=row[1], cost=float(row[2]), proj=float(row[5]), pos='D')
            player_pool.append(player)


player_settings = PlayerPoolSettings(min_salary=minSalary, max_salary=maxSalary)

rosters = run_multi(lineups, rule_set=rules.FD_NASCAR_RULE_SET, player_pool=player_pool, verbose=True)

with open('output.csv', 'w') as outputfile:
    csvwriter = csv.writer(outputfile)
    for roster in rosters[0]:
        players = roster.players
        csvwriter.writerow([players[0].name, players[1].name, players[2].name, players[3].name, players[4].name, players[5].name])
