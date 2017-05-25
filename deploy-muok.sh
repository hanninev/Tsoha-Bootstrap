#!/bin/bash

# Missä kansiossa komento suoritetaan
DIR=$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )

source $DIR/config/environment.sh

echo "Siirretään tiedostot Melkinpaasiin..."

# Siirretään ensin Melkipaasiin ja sitten yhteys Melkkiin

rsync -avH /home/hanninev/NetBeansProjects/Verkkokauppa/ -e ssh hanninev@melkinpaasi.cs.helsinki.fi:/home/hanninev/Tsoha
ssh hanninev@melkinpaasi.cs.helsinki.fi "
cd Tsoha/
bash deployo.sh
exit"

echo "Valmis! Tiedostot siirretty Melkinpaasiin"
