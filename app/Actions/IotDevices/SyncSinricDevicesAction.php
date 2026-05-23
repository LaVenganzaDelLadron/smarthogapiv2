<?php

namespace App\Actions\IotDevices;

use App\Actions\HogPens\SyncSinricRoomsAction;
use App\Integrations\SinricPro\SinricDevicesClient;
use App\Models\HogPens;
use App\Models\IotDevices;
use App\Models\User;

class SyncSinricDevicesAction
{
    public function __construct(
        private SinricDevicesClient $sinricDevicesClient,
        private SyncSinricRoomsAction $syncSinricRoomsAction,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function execute(User $user): array
    {
        $this->syncSinricRoomsAction->execute($user);

        $result = $this->sinricDevicesClient->devices($user);

        if (! ($result['success'] ?? false)) {
            return $result;
        }

        $synced = 0;

        foreach ($result['devices'] ?? [] as $device) {
            if (! is_array($device)) {
                continue;
            }

            $deviceId = $this->deviceString($device, ['id', '_id', 'deviceId', 'device_id']);
            $roomId = $this->roomId($device);

            if ($deviceId === null || $roomId === null) {
                continue;
            }

            $hogPen = HogPens::query()
                ->whereHas('farm', fn ($query) => $query->where('user_id', $user->id))
                ->where('external_provider', 'sinric')
                ->where('external_room_id', $roomId)
                ->first();

            if (! $hogPen instanceof HogPens) {
                continue;
            }

            IotDevices::query()->updateOrCreate(
                [
                    'hog_pen_id' => $hogPen->id,
                    'external_provider' => 'sinric',
                    'external_device_id' => $deviceId,
                ],
                [
                    'type' => $this->deviceType($device),
                    'api_provider' => 'sinric',
                    'status' => ($device['isOnline'] ?? false) === true ? 'online' : 'offline',
                    'external_metadata' => $device,
                ],
            );

            $synced++;
        }

        return [
            'success' => true,
            'synced' => $synced,
            'status' => 200,
        ];
    }

    /**
     * @param  array<string, mixed>  $device
     * @param  list<string>  $keys
     */
    private function deviceString(array $device, array $keys): ?string
    {
        foreach ($keys as $key) {
            $value = $device[$key] ?? null;

            if (is_string($value) && $value !== '') {
                return $value;
            }
        }

        return null;
    }

    /**
     * @param  array<string, mixed>  $device
     */
    private function roomId(array $device): ?string
    {
        $room = $device['room'] ?? null;

        if (is_array($room)) {
            return $this->deviceString($room, ['id', '_id', 'roomId', 'room_id']);
        }

        return $this->deviceString($device, ['roomId', 'room_id', 'room']);
    }

    /**
     * @param  array<string, mixed>  $device
     */
    private function deviceType(array $device): string
    {
        $product = $device['product'] ?? null;

        if (is_array($product)) {
            $type = $this->deviceString($product, ['code', 'name']);

            if ($type !== null) {
                return $type;
            }
        }

        return $this->deviceString($device, ['type', 'name']) ?? 'sinric-device';
    }
}
