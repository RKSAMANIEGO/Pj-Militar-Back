<?php

namespace app\controller;

use config\Database;
use app\model\Miembro;
use app\utils\Response;

use OpenApi\Attributes as OA;
use OpenApi\Attributes\JsonContent;
use OpenApi\Processors\OperationId;

use function PHPSTORM_META\type;

#[OA\Info(title: "Api de la tabla Miembros", version: "1.0.0", description: "Gestion de todos los miembros de la promocion XIV ...")]
#[OA\Server(url: "http://localhost/Backend---Militar/public", description: "Path Principal")]
class MiembroController
{
    private $miembroModel;

    function __construct(Database $db)
    {
        $this->miembroModel = new Miembro($db);
    }

    #[OA\Get(
        path: "/miembros/total/{estado}",
        operationId: "getCountMiembrosActivos",
        summary: "Cantidad de todos los miembros activos",
        parameters: [
            new OA\Parameter(
                name: "estado",
                in: "path",
                description: "Estado (ACTIVO || FALLECIDO)",
                required: true,
                schema: new OA\Schema(type: "string")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Cantidad de Miembros Activos",
                content: new OA\JsonContent(type: "integer")
            )
        ]
    )]
    public function totalCountMiembro($estado)
    {
        $result = $this->miembroModel->countMiembro($estado);
        Response::json($result);
    }


    #[OA\Get(
        path: "/miembros",
        operationId: "ListarAllMiembrosActivos",
        summary: "Obtener la lista de todos los miembros Activos con sus logros e imagenes  de la promocion",
        responses: [
            new OA\Response(
                response: 200,
                description: "Lista de miembros activos",
                content: new OA\JsonContent(
                    type: "array",
                    items: new OA\Items(
                        type: "object",
                        properties: [
                            new OA\Property(property: "id_miembro", type: "int"),
                            new OA\Property(property: "nombres", type: "string"),
                            new OA\Property(property: "cargo", type: "string"),
                            new OA\Property(property: "descripcion", type: "string"),
                            new OA\Property(property: "num_contacto", type: "string"),
                            new OA\Property(property: "correo", type: "string"),
                            new OA\Property(property: "lugar", type: "string"),
                            new OA\Property(property: "logros", type: "string"),
                            new OA\Property(property: "ruta_imagenes", type: "string"),
                        ]
                    )
                )
            ),
            new OA\Response(
                response: 204,
                description: "No hay miembros activos",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(
                            property: "message",
                            type: "string"
                        )
                    ]
                )
            )
        ]
    )]
    public function listAll()
    {
        $miembros = $this->miembroModel->getData();

        if ($miembros == null) {
            echo "La tabla Miembros no cuenta con Registros ";
        }
        Response::json($miembros);
    }


    #[OA\Get(
        path: "/miembros/{id}",
        operationId: "GetMiembroById",
        summary: "Obtener el Miembro con sus logros e imagenes por Id",
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer"),
                description: "Id del Miembro"
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Miembro encontrado",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(
                            property: "id",
                            type: "integer"
                        )
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: "Miembro no encontrado",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(
                            property: "error",
                            type: "string"
                        )
                    ]
                )
            )

        ]

    )]
    public function getById($id)
    {
        $result =  $this->miembroModel->getDataById($id);
        if ($result === null) {
            echo json_encode(["message" => "El ID $id No Existe"]);
        }
        Response::json($result);
    }


    #[OA\Delete(
        path: "/miembros/{id}",
        operationId: "getDeleteById",
        description: "Eliminar un miembro por su ID",
        summary: "Eliminar un miembro por su Id",
        parameters: [
            new OA\Parameter(
                name: "id",
                required: true,
                in: "path",
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Miembro Eliminado Exitosamente",
                content: [
                    new OA\JsonContent(
                        type: "object",
                        properties: [
                            new OA\Property(
                                property: "message",
                                type: "string"
                            )
                        ]
                    )
                ]
            ),
            new OA\Response(
                response: 400,
                description: "El Id no se Existe",
                content: [
                    new OA\JsonContent(
                        type: "object",
                        properties: [
                            new OA\Property(
                                property: "message",
                                type: "string"
                            )
                        ]
                    )
                ]
            )
        ]
    )]
    public function deleteById($id)
    {
        $result = $this->miembroModel->deleteData($id);
        if ($result === false) {
            Response::json(["message" => "El Miembro con ID $id No Existe"]);
        }
        if ($result === null) {
            Response::json(["message" => "No se Encontraro el Id $id"]);
        }
        Response::json(["message" => "Miembro con ID $id Eliminado Correctamente"]);
    }


    #[OA\Put(
        path: "/miembros/{id}",
        operationId: "PutMiembroById",
        description: "Actualizar los miembros por Id",
        summary: "Actualizar miembros por su Id",
        parameters: new OA\Parameter(
            name: "id",
            in: "path",
            required: true,
            schema: new OA\Schema(type: "integer")
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Se Actualizo el Miembro Exitosamente",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(
                            property: "message",
                            type: "string"
                        )
                    ]
                )

            ),
            new OA\Response(
                response: 400,
                description: "Se Requiere mas Campos",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(
                            property: "message",
                            type: "string"
                        )
                    ]
                )
            )
        ]



    )]

    public function updateById($id)
    {
        $resultMiembro = $this->miembroModel->getDataMiembroById($id);

        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data["nombres"], $data["cargo"], $data["descripcion"])) {
            Response::json(["Error" => "Se requiere mas campos"], 400);
        }

        $resultMiembro = $this->miembroModel->putData($id, $data["nombres"], $data["cargo"], $data["descripcion"]);

        if ($resultMiembro === null) {
            Response::json(["Message" => "El Miembro con ID $id No Existe"], 404);
        }
        Response::json(["message" => "Miembroooooooooo  con ID $id Se Actualizo Correctamente"]);

        /*$resultContacto = $this->contactoModel->update($idContacto, $data["id_contacto"]["numero"], $data["id_contacto"]["correo"], $data["id_contacto"]["lugar"]);

        if (!$resultContacto) {
            Response::json(["Error" => "No se pudo Actualziar el registro con ID $idContacto"]);
        }

        if ($resultContacto === null) {
            Response::json(["Message" => "El Contacto con ID $id No Existe"]);
        }
        */
        /*$idContacto = $resultMiembro["id_contacto"];
        if (!isset($data["id_contacto"], $data["nombres"], $data["cargo"], $data["descripcion"])) {
            Response::json(["Error" => "Se requiere mas campos"], 400);
        }
        */
    }
}
