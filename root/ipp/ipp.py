#!/usr/bin/python
from struct import pack, unpack, error as structerr
import stat

IPP_TAG_ZERO = 0x00
IPP_TAG_OPERATION = 0x01
IPP_TAG_JOB = 0x02
IPP_TAG_END = 0x03
IPP_TAG_PRINTER = 0x04
IPP_TAG_UNSUPPORTED_GROUP = 0x05
IPP_TAG_SUBSCRIPTION = 0x06
IPP_TAG_EVENT_NOTIFICATION = 0x07
IPP_TAG_UNSUPPORTED_VALUE = 0x10
IPP_TAG_DEFAULT = 0x11
IPP_TAG_UNKNOWN = 0x12
IPP_TAG_NOVALUE = 0x13
IPP_TAG_NOTSETTABLE = 0x15
IPP_TAG_DELETEATTR = 0x16
IPP_TAG_ADMINDEFINE = 0x17
IPP_TAG_INTEGER = 0x21
IPP_TAG_BOOLEAN = 0x22
IPP_TAG_ENUM = 0x23
IPP_TAG_STRING = 0x30
IPP_TAG_DATE = 0x31
IPP_TAG_RESOLUTION = 0x32
IPP_TAG_RANGE = 0x33
IPP_TAG_BEGIN_COLLECTION = 0x34
IPP_TAG_TEXTLANG = 0x35
IPP_TAG_NAMELANG = 0x36
IPP_TAG_END_COLLECTION = 0x37
IPP_TAG_TEXT = 0x41
IPP_TAG_NAME = 0x42
IPP_TAG_KEYWORD = 0x44
IPP_TAG_URI = 0x45
IPP_TAG_URISCHEME = 0x46
IPP_TAG_CHARSET = 0x47
IPP_TAG_LANGUAGE = 0x48
IPP_TAG_MIMETYPE = 0x49
IPP_TAG_MEMBERNAME = 0x4a
IPP_TAG_MASK = 0x7fffffff
IPP_TAG_COPY = -0x7fffffff-1

IPP_RES_PER_INCH = 3
IPP_RES_PER_CM = 4

IPP_FINISHINGS_NONE = 3
IPP_FINISHINGS_STAPLE = 4
IPP_FINISHINGS_PUNCH = 5
IPP_FINISHINGS_COVER = 6
IPP_FINISHINGS_BIND = 7
IPP_FINISHINGS_SADDLE_STITCH = 8
IPP_FINISHINGS_EDGE_STITCH = 9
IPP_FINISHINGS_FOLD = 10
IPP_FINISHINGS_TRIM = 11
IPP_FINISHINGS_BALE = 12
IPP_FINISHINGS_BOOKLET_MAKER = 13
IPP_FINISHINGS_JOB_OFFSET = 14
IPP_FINISHINGS_STAPLE_TOP_LEFT = 20
IPP_FINISHINGS_STAPLE_BOTTOM_LEFT = 21
IPP_FINISHINGS_STAPLE_TOP_RIGHT = 22
IPP_FINISHINGS_STAPLE_BOTTOM_RIGHT = 23
IPP_FINISHINGS_EDGE_STITCH_LEFT = 24
IPP_FINISHINGS_EDGE_STITCH_TOP = 25
IPP_FINISHINGS_EDGE_STITCH_RIGHT = 26
IPP_FINISHINGS_EDGE_STITCH_BOTTOM = 27
IPP_FINISHINGS_STAPLE_DUAL_LEFT = 28
IPP_FINISHINGS_STAPLE_DUAL_TOP = 29
IPP_FINISHINGS_STAPLE_DUAL_RIGHT = 30
IPP_FINISHINGS_STAPLE_DUAL_BOTTOM = 31
IPP_FINISHINGS_BIND_LEFT = 50
IPP_FINISHINGS_BIND_TOP = 51
IPP_FINISHINGS_BIND_RIGHT = 52
IPP_FINISHINGS_BIND_BOTTO = 53

IPP_ORIENT_PORTRAIT = 3
IPP_ORIENT_LANDSCAPE = 4
IPP_ORIENT_REVERSE_LANDSCAPE = 5
IPP_ORIENT_REVERSE_PORTRAIT = 6

IPP_QUALITY_DRAFT = 3
IPP_QUALITY_NORMAL = 4
IPP_QUALITY_HIGH = 5

IPP_JOB_PENDING = 3
IPP_JOB_HELD = 4
IPP_JOB_PROCESSING = 5
IPP_JOB_STOPPED = 6
IPP_JOB_CANCELLED = 7
IPP_JOB_ABORTED = 8
IPP_JOB_COMPLETE = 9

IPP_PRINTER_IDLE = 3
IPP_PRINTER_PROCESSING = 4
IPP_PRINTER_STOPPED = 5

IPP_STATE_ERROR = -1
IPP_STATE_IDLE = 0
IPP_STATE_HEADER = 1
IPP_STATE_ATTRIBUTE = 2
IPP_STATE_DATA = 3

IPP_OP_RESERVED = 0x0000
IPP_OP_PRINT_JOB = 0x0002
IPP_OP_PRINT_URI = 0x0003
IPP_OP_VALIDATE_JOB = 0x0004
IPP_OP_CREATE_JOB = 0x0005
IPP_OP_SEND_DOCUMENT = 0x0006
IPP_OP_SEND_URI = 0x0007
IPP_OP_CANCEL_JOB = 0x0008
IPP_OP_GET_JOB_ATTRIBUTES = 0x0009
IPP_OP_GET_JOBS = 0x000a
IPP_OP_GET_PRINTER_ATTRIBUTES = 0x000b
IPP_OP_HOLD_JOB = 0x000c
IPP_OP_RELEASE_JOB = 0x000d
IPP_OP_RESTART_JOB = 0x000e
IPP_OP_PAUSE_PRINTER = 0x0010
IPP_OP_RESUME_PRINTER = 0x0011
IPP_OP_PURGE_JOBS = 0x0012
IPP_OP_SET_PRINTER_ATTRIBUTES = 0x0013
IPP_OP_SET_JOB_ATTRIBUTES = 0x0014
IPP_OP_GET_PRINTER_SUPPORTED_VALUES = 0x0015
IPP_OP_CREATE_PRINTER_SUBSCRIPTION = 0x0016
IPP_OP_CREATE_JOB_SUBSCRIPTION = 0x0017
IPP_OP_GET_SUBSCRIPTION_ATTRIBUTES = 0x0018
IPP_OP_GET_SUBSCRIPTIONS = 0x0019
IPP_OP_RENEW_SUBSCRIPTION = 0x001a
IPP_OP_CANCEL_SUBSCRIPTION = 0x001b
IPP_OP_GET_NOTIFICATIONS = 0x001c
IPP_OP_SEND_NOTIFICATIONS = 0x001d
IPP_OP_GET_PRINT_SUPPORT_FILES = 0x0021
IPP_OP_ENABLE_PRINTER = 0x0022
IPP_OP_DISABLE_PRINTER = 0x0023
IPP_OP_PAUSE_PRINTER_AFTER_CURRENT_JOB = 0x0024
IPP_OP_HOLD_NEW_JOBS = 0x0025
IPP_OP_RELEASE_HELD_NEW_JOBS = 0x0026
IPP_OP_DEACTIVATE_PRINTER = 0x0027
IPP_OP_ACTIVATE_PRINTER = 0x0028
IPP_OP_RESTART_PRINTER = 0x0029
IPP_OP_SHUTDOWN_PRINTER = 0x002a
IPP_OP_STARTUP_PRINTER = 0x002b
IPP_OP_REPROCESS_JOB = 0x002c
IPP_OP_CANCEL_CURRENT_JOB = 0x002d
IPP_OP_SUSPEND_CURRENT_JOB = 0x002e
IPP_OP_RESUME_JOB = 0x002f
IPP_OP_PROMOTE_JOB = 0x0030
IPP_OP_SCHEDULE_JOB_AFTER = 0x0031
IPP_OP_PRIVATE = 0x4000

IPP_STATUS_OK = 0x0000
IPP_STATUS_OK_SUBST = 0x0001
IPP_STATUS_OK_CONFLICT = 0x0002
IPP_STATUS_OK_IGNORED_SUBSCRIPTIONS = 0x0003
IPP_STATUS_OK_IGNORED_NOTIFICATIONS = 0x0004
IPP_STATUS_OK_TOO_MANY_EVENTS = 0x0005
IPP_STATUS_OK_BUT_CANCEL_SUBSCRIPTION = 0x0006
IPP_STATUS_REDIRECTION_OTHER_SITE = 0x0300
IPP_STATUS_BAD_REQUEST = 0x0400
IPP_STATUS_FORBIDDEN = 0x0401
IPP_STATUS_NOT_AUTHENTICATED = 0x0402
IPP_STATUS_NOT_AUTHORIZED = 0x0403
IPP_STATUS_NOT_POSSIBLE = 0x0404
IPP_STATUS_TIMEOUT = 0x0405
IPP_STATUS_NOT_FOUND = 0x0406
IPP_STATUS_GONE = 0x0407
IPP_STATUS_REQUEST_ENTITY = 0x0408
IPP_STATUS_REQUEST_VALUE = 0x0409
IPP_STATUS_DOCUMENT_FORMAT = 0x040a
IPP_STATUS_ATTRIBUTES = 0x040b
IPP_STATUS_URI_SCHEME = 0x040c
IPP_STATUS_CHARSET = 0x040d
IPP_STATUS_CONFLICT = 0x040e
IPP_STATUS_COMPRESSION_NOT_SUPPORTED = 0x040f
IPP_STATUS_COMPRESSION_ERROR = 0x0410
IPP_STATUS_DOCUMENT_FORMAT_ERROR = 0x0411
IPP_STATUS_DOCUMENT_ACCESS_ERROR = 0x0412
IPP_STATUS_ATTRIBUTES_NOT_SETTABLE = 0x0413
IPP_STATUS_IGNORED_ALL_SUBSCRIPTIONS = 0x0414
IPP_STATUS_TOO_MANY_SUBSCRIPTIONS = 0x0415
IPP_STATUS_IGNORED_ALL_NOTIFICATIONS = 0x0416
IPP_STATUS_PRINT_SUPPORT_FILE_NOT_FOUND = 0x0417
IPP_STATUS_INTERNAL_ERROR = 0x0500
IPP_STATUS_OPERATION_NOT_SUPPORTED = 0x0501
IPP_STATUS_SERVICE_UNAVAILABLE = 0x0502
IPP_STATUS_VERSION_NOT_SUPPORTED = 0x0503
IPP_STATUS_DEVICE_ERROR = 0x0504
IPP_STATUS_TEMPORARY_ERROR = 0x0505
IPP_STATUS_NOT_ACCEPTING = 0x0506
IPP_STATUS_PRINTER_BUSY = 0x0507
IPP_STATUS_ERROR_JOB_CANCELLED = 0x0508
IPP_STATUS_MULTIPLE_JOBS_NOT_SUPPORTED = 0x0509
IPP_STATUS_PRINTER_IS_DEACTIVATED = 0x50a

class Attributes(object):
    values = {}
    def __init__(self, tag=None):
        self.tag = tag
    def __setitem__(self, key, value):
        if key not in self.values:
            self.values[key] = []
        self.values[key].append(value)
    def __getitem__(self, key):
        if not key in self.values:
            self.values[key] = []
        return self.values[key]
    def __delitem__(self, key):
        del self.values[key]
    def __len__(self):
        return len(self.values)
    def __contains__(self, item):
        return item in self.values
    def output(self, f):
        #data = chr(self.tag)
        f.write(chr(self.tag))
        for attr_name in self.values.keys():
            cattr = 0
            for vtag, value in self.values[attr_name]:
                #data += str(vtag)
                f.write(chr(int(vtag)))
                if cattr == 0:
                    #data += pack('>H', len(attr_name)) + attr_name
                    f.write(pack('>H', len(attr_name)) + attr_name)
                    cattr = 1
                else:
                    #data += pack('>H', 0)
                    f.write(pack('>H', 0))
                if vtag is IPP_TAG_BOOLEAN:
                    f.write(pack('>H', 1) + chr(value))
                elif vtag in (IPP_TAG_INTEGER, IPP_TAG_ENUM):
                    f.write(pack('>H', 4) + pack('>I', value))
                else:
                    f.write(pack('>H', len(value)) + value)

    def input(self, f):
        tag = unpack('>B', f.read(1))[0]
        if tag not in range(IPP_TAG_ZERO, IPP_TAG_UNSUPPORTED_VALUE):
            f.seek(-1, 1)
            print tag
            return False
        self.tag = tag
        attr = None
        try:
            while not f.closed:
                vtag = unpack('>B', f.read(1))[0]
                if not (vtag > IPP_TAG_UNSUPPORTED_VALUE and vtag < IPP_TAG_MASK):
                    f.seek(-1, 1)
                    return True
                name = f.read(unpack('>H', f.read(2))[0])
                value = f.read(unpack('>H', f.read(2))[0])
                if len(name):
                    attr = name
                self[attr] = (str(vtag), str(value))
        except structerr:
            return False
        return True

class Packet(object):
    version = status = requestid = attr = dataf = datap = None
    def input_version(self, ver): self.version = map(ord, ver)
    def input_status(self, status): self.status = unpack('>H', status)[0]
    def input_requestid(self, reqid): self.requestid = unpack('>I', reqid)[0]
    def input(self, f):
        self.input_version(f.read(2))
        if self.version not in ([1,0], [1,1]):
            f.seek(-2, 1)
            return False
        self.input_status(f.read(2))
        #if self.status not in range(IPP_OP_RESERVED, IPP_OP_PRIVATE):
        #    f.seek(-4, 1)
        #    return False
        self.input_requestid(f.read(4))
        self.attr = []
        while not f.closed:
            a = Attributes()
            if not a.input(f):
                break
            self.attr.append(a)
        self.datap = f.tell()
        self.dataf = f
        return True

    def output(self, f):
        f.write(pack('>BB', *self.version))
        f.write(pack('>H', self.status))
        f.write(pack('>I', self.requestid))
        for attr in self.attr:
            attr.output(f)
        f.write(pack('>B', IPP_TAG_END))
        try:
            if self.datap < os.fstat(self.dataf.fileno()).st_size:
                dataf.seek(self.datap)
                f.write(dataf.read())
        except:
            return False
        return True
