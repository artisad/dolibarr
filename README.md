# Dolibarr
Ce dépôt amène des templates et des configuration pour une installation personnalisée de Dolibarr

Il se base sur le dépoiement de l'image docker de [@tuxgasy/docker-dolibarr](https://github.com/tuxgasy/docker-dolibarr)

L'architecture se veut être déployée derrière un proxy de type [@NginxProxyManager/nginx-proxy-manager](https://github.com/NginxProxyManager/nginx-proxy-manager), faisant passerelle entre le réseau "web" et les ports 80 et 443 de l'hôte.
