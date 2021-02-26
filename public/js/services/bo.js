App.factory('bo', ['$http', 'URL_API', '$resource', function ($http, URL_API, $resource) {

    'use strict';

    function copiarAtributos(origem, destino) {
        if (origem && destino && typeof origem === 'object' && typeof destino === 'object') {
            for (var f in origem) {
                if (origem.hasOwnProperty(f)) {
                    destino[f] = origem[f];
                }
            }
        }
    }

    // Template para BOs
    function BoTemplate(urlServico, params) {
        this.url = URL_API + urlServico;
        this.path = function (caminho) {
            caminho = caminho || '';
            return this.url + caminho;
        };
        copiarAtributos(params, this);
    }

    // Template do Cliente Rest para CRUDs.
    function CrudTemplate(urlServico, params) {
        this.url = URL_API + urlServico;

        this.path = function (caminho) {
            caminho = caminho || '';
            return this.url + caminho;
        };

        this.crud = $resource(this.path('/:id'), {
            id: '@_id'
        }, {
            update: {
                method: 'PUT'
            },
            query: {
                method: 'GET',
                isArray: false
            }
        });

        this.pesquisar = function (params, pagina, tamanho) {
            params = params || {};
            params.pagina = pagina;
            params.tamanho = tamanho;

            return $http.get(this.url, params);
        };

        this.ativar = function (chaves, ativo) {
            return $http.put(this.url + '/ativa/' + ativo, chaves);
        };

        this.remover = function (chaves) {
            return $http.delete(
                this.url, {
                    params: {
                        id: chaves
                    }
                }
            );
        };

        copiarAtributos(params, this);
    } // fim CrudTemplate

    // Servicos do 'BO'
    return {
        // Servico CRUD para TipoDocumento.
        TipoDocumento: new CrudTemplate('tipo_documento', {
            pesquisarPelaArea: function (idTipoDocumento) {
                return $http.get(this.path('/pesquisar-pela-area/' + idTipoDocumento));
            },
            buscarPorIdAtivo: function (id) {
                return $http.get(this.path('/buscar-por-id-ativo/' + id));
            }
        }),
        AtrTable: new CrudTemplate('atr-table', {
            lookupByDate: function (params) {
                return $http.post(this.path('/lookup-by-date'), params);
            }
        }),
        Empty: {}
    };
}]);
