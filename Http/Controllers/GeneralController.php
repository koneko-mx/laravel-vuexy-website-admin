<?php

namespace Koneko\VuexyWebsiteAdmin\Http\Controllers;;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Catalog\DropdownList;
use App\Http\Controllers\Controller;

class GeneralController extends Controller
{
    public function webApp()
    {
        $breadcrumbs = [
            ['route' => 'admin.home', 'name' => "Inicio"],
            ['name' => "Ajustes"],
            ['name' => "General"],
            ['name' => "Aplicación web", 'active' => true],
        ];

        return view('admin.settings.general.webapp-index', compact('breadcrumbs'));
    }

    public function store()
    {
        $breadcrumbs = [
            ['route' => 'admin.home', 'name' => "Inicio"],
            ['name' => "Ajustes"],
            ['name' => "General"],
            ['name' => "Empresa", 'active' => true],
        ];

        return view('admin.settings.general.store-index', compact('breadcrumbs'));
    }

    public function divisas(Request $request)
    {
        if ($request->ajax()) {
            $query = DropdownList::select(
                    'dropdown_lists.id',
                    'dropdown_lists.single',
                    'sat_moneda.descripcion',
                    'dropdown_lists.param1',
                    'dropdown_lists.param2',
                    'dropdown_lists.param3',
                    'dropdown_lists.param4',
                    'dropdown_lists.created_at'
                )
                ->Join('sat_moneda', 'dropdown_lists.single', '=', 'sat_moneda.c_moneda')
                ->where('dropdown_lists.label', DropdownList::SYS_DIVISA);

            // Manejar el ordenamiento del lado del servidor basado en las columnas que DataTables solicita
            if ($request->has('order')) {
                $columns = [2 => 'single', 'descripcion', 'param1', 'param2', 'param3', 'param4', 'created_at'];

                foreach ($request->get('order') as $order) {
                    $query->orderBy($columns[$order['column']], $order['dir']);
                }
            }

            $warehouses = $query->get();

            return DataTables::of($warehouses)
                ->only(['id', 'single', 'descripcion', 'param1', 'param2', 'param3', 'param4', 'created_at'])
                ->addIndexColumn()
                ->editColumn('created_at', function ($user) {
                    return $user->created_at->format('Y-m-d');
                })
                ->make(true);
        }

        $breadcrumbs = [
            ['route' => 'admin.home', 'name' => "Inicio"],
            ['name' => "Ajustes"],
            ['name' => "General"],
            ['name' => "Divisas", 'active' => true],
        ];

        return view('admin.settings.general.divisas-index', compact('breadcrumbs'));
    }

    public function warehouses(Request $request)
    {
        if ($request->ajax()) {
            $query = DropdownList::select(
                    'dropdown_lists.id',
                    'dropdown_lists.single',
                    'dropdown_lists.param1',
                    'dropdown_lists.status',
                    'dropdown_lists.created_at'
                )
                ->where('dropdown_lists.label', DropdownList::SYS_WAREHOUSE);

            // Manejar el ordenamiento del lado del servidor basado en las columnas que DataTables solicita
            if ($request->has('order')) {
                $columns = [2 => 'single', 'param1', 'status', 'created_at'];

                foreach ($request->get('order') as $order) {
                    $query->orderBy($columns[$order['column']], $order['dir']);
                }
            }

            $warehouses = $query->get();

            return DataTables::of($warehouses)
                ->only(['id', 'single', 'param1', 'status', 'created_at'])
                ->addIndexColumn()
                ->editColumn('created_at', function ($user) {
                    return $user->created_at->format('Y-m-d');
                })
                ->make(true);
        }

        $breadcrumbs = [
            ['route' => 'admin.home', 'name' => "Inicio"],
            ['name' => "Ajustes"],
            ['name' => "General"],
            ['name' => "Almacenes", 'active' => true],
        ];

        return view('admin.settings.general.warehouses-index', compact('breadcrumbs'));
    }

    public function formasPago2()
    {
        $breadcrumbs = [
            ['route' => 'admin.home', 'name' => "Inicio"],
            ['name' => "Ajustes"],
            ['name' => "General"],
            ['name' => "Formas de pago ²", 'active' => true],
        ];

        return view('admin.settings.general.formas-pago-2-index', compact('breadcrumbs'));
    }

    public function apiBanxico()
    {
        $breadcrumbs = [
            ['route' => 'admin.home', 'name' => "Inicio"],
            ['name' => "Ajustes"],
            ['name' => "General"],
            ['name' => "API BANXICO", 'active' => true],
        ];

        return view('admin.settings.general.api-banxico-index', compact('breadcrumbs'));
    }

    public function smtp()
    {
        $breadcrumbs = [
            ['route' => 'admin.home', 'name' => "Inicio"],
            ['name' => "Ajustes"],
            ['name' => "General"],
            ['name' => "Servidor de correo SMTP", 'active' => true],
        ];

        return view('admin.settings.general.smtp-index', compact('breadcrumbs'));
    }

    public function checkUniqueWarehouse(Request $request)
    {
        $id = $request->input('id');
        $single = $request->input('single');

        $exists = DropdownList::where('single', $single)
            ->where('label', DropdownList::SYS_WAREHOUSE)
            ->where('id', '!=', $id) // Excluir el registro actual
            ->exists();

        return response()->json(['isUnique' => !$exists]);
    }

    public function checkUniqueDivisa(Request $request)
    {
        $id = $request->input('id');
        $single = $request->input('single');

        $exists = DropdownList::where('single', $single)
            ->where('label', DropdownList::SYS_DIVISA)
            ->where('id', '!=', $id) // Excluir el registro actual
            ->exists();

        return response()->json(['isUnique' => !$exists]);
    }

}
