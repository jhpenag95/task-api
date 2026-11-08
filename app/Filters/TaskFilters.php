<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class TaskFilters
{
    public function __construct(private Request $request) {}

    public function apply(Builder $query): Builder
    {
        $this->status($query);
        $this->search($query);
        $this->sort($query);

        return $query;
    }

    private function status(Builder $query): void
    {
        if (! $this->request->filled('status')) {
            return;
        }

        $query->where(
            'status',
            $this->request->status
        );
    }

    private function search(Builder $query): void
    {
        if (! $this->request->filled('search')) {
            return;
        }

        $query->where(
            'title',
            'like',
            '%' . $this->request->search . '%'
        );
    }

    private function sort(Builder $query): void
    {
        //$allowed = significa permitido, es un arreglo que contiene los campos que se permiten para ordenar las tareas
        $allowed = [
            'title',
            'status',
            'created_at',
        ];

        //aqui se esta obteniendo el parametro sort de la query string, si no existe se asigna el valor por defecto de created_at
        $sort = $this->request->input(
            'sort',
            'created_at'
        );

        //aqui se esta obteniendo el parametro direction de la query string, si no existe se asigna el valor por defecto de desc
        $direction = $this->request->input(
            'direction',
            'desc'
        );

        //si el valor de sort no esta en el arreglo de campos permitidos, se asigna el valor por defecto de created_at
        if (! in_array($sort, $allowed)) {
            $sort = 'created_at';
        }

        //si el valor de direction no es asc o desc, se asigna el valor por defecto de desc
        if (! in_array($direction, ['asc', 'desc'])) {
            $direction = 'desc';
        }

        $query->orderBy(
            $sort,
            $direction
        );
    }
}
