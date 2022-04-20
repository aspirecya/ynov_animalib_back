<?php

namespace App\GraphQL\Queries\Appointment;

use App\Models\Appointment;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Facades\Auth;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class GetAppointmentByMonth
{
    /**
     * Return a value for the field.
     *
     * @param  @param  null  $root Always null, since this field has no parent.
     * @param array<string, mixed> $args The field arguments passed by the client.
     * @param GraphQLContext $context Shared between all fields.
     * @param ResolveInfo $resolveInfo Metadata for advanced query resolution.
     * @return mixed
     */
    public function __invoke($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        if($args['zeroIndexed']) {
            $args['month'] += 1;
        }

        return Appointment::whereMonth('timeslot', $args['month'])->where('user_id', Auth::user()->id)->get();
    }
}
