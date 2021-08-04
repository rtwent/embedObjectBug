# embedObjectBug
Embed object bug when using jsonb on postgresql

In the entity App\Entity\CachedGeo we store translations of the regions in postgres jsonb format, 
e.g. {"ua": {"name": "some name", "declination": "in name"}}.

All methods work perfectly, but method "patch" gives strange behaviour.
While updating embedded json (by patch method) - nothing happens.
`
curl -X 'PATCH' \
  'http://localhost:8089/cached_geos/1ebf12e9-ff5d-6564-ba92-8d5ceeb93c2a' \
  -H 'accept: application/ld+json' \
  -H 'Content-Type: application/merge-patch+json' \
  -d '{
  "i18n": {
    "ru": {
      "name": "ru",
      "declination": "in ru"
    },
    "ua": {
      "name": "ua",
      "declination": "in ua"
    }
  },
  "lft": 2,
  "rgt": 3
}'
` 
Expected behaviour is changing the value of i18n field in database - but got old value.

After digging, I've found solution, but according to bugs https://github.com/api-platform/core/issues/4293 and https://github.com/api-platform/core/pull/1534 
it is hard for me to understand: am i on the right way or I have to read manuals more scrupulously.

After deserialization process - I had everything as expected, but while persisting - strange doctrine behaviour happens. 
Please look at App\DataPersister\CachedGeoDataPersister comment at line 52. Is it expected behaviour? 
