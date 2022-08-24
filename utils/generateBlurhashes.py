import blurhash
import json
import requests
import PIL

with open('top100stations.json') as json_data:
    allStations = json.load(json_data)

r = None

stationsBlurHash = {'stations': []}

for station in allStations:

    stationuuid = station['stationuuid']
    stationfavicon = station['favicon']

    try:
        r = requests.get(stationfavicon, allow_redirects=True)
    except:
        pass
    if (r):
        if (r.status_code == 200):
            open('images/'+stationuuid, 'wb').write(r.content)
            imageFile = 'images/'+stationuuid
            try:
                blurHash = blurhash.encode(imageFile, x_components=4, y_components=4)
                print(station['stationuuid'], " - ", stationfavicon, " - ", blurHash)
                stationsBlurHash['stations'].append({stationuuid: blurHash})
            except:
                pass

with open('stations100BlurHash.json', 'w') as the_file:
    json.dump(stationsBlurHash, the_file)
the_file.close()
