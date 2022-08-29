<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::latest();
        if ($search = request()->search)
            $user->where('name', 'LIKE', "%$search%")
                ->orWhere('email', 'LIKE', "%$search%")
                ->orWhere('type', 'LIKE', "%$search%");
        return $user->paginate(5);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate(User::$rules);

        return User::create($validated);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return ['user' => $user];
    }

    /**
     * Display the authnticated user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        $user = auth('api')->user();

        if (request()->method() == 'GET')
            return ['user' => $user];

        $validated = request()->validate([
            ...User::$rules,
            'email' => 'required|email:rfc,dns|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|max:20',
            'image' => 'nullable',
        ]);

        if ($validated['image'] != $user->image) {

            $explode = explode(',', $validated['image']);
            $allow = ['png', 'jpg', 'jpeg', 'svg'];
            $format = str_replace(
                ['data:image/', ';', 'base64',],
                ['', '', '',],
                $explode[0]
            );

            // check file format
            if (in_array($format, $allow) && preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $explode[1])) {
                $imageName = time() . '.' . $format;

                \Storage::disk('public')->put('profile/' . $imageName, base64_decode($explode[1]));

                $validated['image'] = $imageName;

                \Storage::disk('public')->delete('profile/' . $user->image);
            }
        }

        // If any value is null remove it
        $validated = array_filter($validated);

        return $user->update($validated);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            ...User::$rules,
            'email' => 'required|email:rfc,dns|unique:users,email,' . $id,
            'password' => 'nullable|min:6|max:20',
        ]);

        // If any value is null remove it
        $validated = array_filter($validated);

        return $user->update($validated);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return ['message' => 'User Deleted Successfully!'];
    }
}
